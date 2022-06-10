<?php

declare(strict_types=1);

use Narrowspark\HttpEmitter\SapiEmitter;
use Proxy\Config;
use Proxy\Http\Request;
use Proxy\Proxy;
use ProxyApp\Controller\FormController;

+

define('PROXY_START', microtime(true));

if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}

if (!file_exists(ROOT . '/vendor/autoload.php')) {
    die('Make sure you perform the `composer update` command.');
}

include ROOT . '/vendor/autoload.php';

if (!function_exists('curl_version')) {
    die("cURL extension is not loaded!");
}

// load config...
Config::load('./config.php');

// custom config file to be written to by a bash script or something
Config::load('./custom_config.php');

if (!Config::get('app_key')) {
    die("app_key inside config.php cannot be empty!");
}

if (!Config::get('expose_php')) {
    header_remove('X-Powered-By');
}

// start the session
if (Config::get('session_enable')) {
    session_start();
}

// how are our URLs be generated from this point? this must be set here so the proxify_url function below can make use of it
if (Config::get('url_mode') == 2) {
    Config::set('encryption_key', md5(Config::get('app_key') . $_SERVER['REMOTE_ADDR']));
} elseif (Config::get('url_mode') == 3) {
    Config::set('encryption_key', md5(Config::get('app_key') . session_id()));
}

if (Config::get('session_enable')) {
    // very important!!! otherwise requests are queued while waiting for session file to be unlocked
    session_write_close();
}

$request = (new \Kraber\Http\Factory\ServerRequestFactory())->createServerRequest(
    method: $_SERVER['REQUEST_METHOD'],
    uri: ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
    serverParams: $_SERVER
);


try {
// form submit in progress...
    if (isset($_POST['url'])) {

        $url = $_POST['url'];
        $url = add_http($url);

        header("HTTP/1.1 302 Found");
        header('Location: ' . proxify_url($url));
        exit;

    } elseif (!isset($_GET['q'])) {

        // must be at homepage - should we redirect somewhere else?
        if (Config::get('index_redirect')) {

            // redirect to...
            header("HTTP/1.1 302 Found");
            header("Location: " . Config::get('index_redirect'));

        } else {
            (new SapiEmitter())->emit(
                (new FormController($request))()
            );
        }

    } else {

        (new SapiEmitter())->emit(
            (new \ProxyApp\Controller\RunProxyController($request))()
        );

    }

} catch (\ProxyApp\Exceptions\TemplateMissingException $e) {
}