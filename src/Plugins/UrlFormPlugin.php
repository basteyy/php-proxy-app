<?php

/**
 * PHP-Proxy-App
 *
 * Web Proxy Application built on php-proxy library ready to be installed on your server
 * @see https://github.com/Athlon1600/php-proxy-app
 * @license MIT
 * @author https://github.com/Athlon1600/php-proxy-app/graphs/contributors
 */

declare(strict_types=1);

namespace ProxyApp\Plugins;

use Proxy\Config;
use Proxy\Event\ProxyEvent;
use Proxy\Plugin\AbstractPlugin;
use ProxyApp\Plugins\Interfaces\ProxyPluginInterface;

class UrlFormPlugin extends AbstractPlugin implements ProxyPluginInterface
{
    public function onCompleted(ProxyEvent $event)
    {

        $request = $event['request'];
        $response = $event['response'];

        $url = $request->getUri();

        // we attach url_form only if this is a html response
        if (!is_html($response->headers->get('content-type'))) {
            return;
        }

        // this path would be relative to index.php that included it?
        $url_form = $this->getRenderHelper()->render("./templates/url_form.php", array(
            'url' => $url
        ));

        $output = $response->getContent();

        // remove favicon if so
        if (Config::get('replace_icon')) {

            $output = preg_replace_callback('/<link[^>]+rel=".*?(?:shortcut|icon).*?"[^>]+>/', function ($matches) {
                return "";
            }, $output);
        }

        // does the html page contain <body> tag, if so insert our form right after <body> tag starts
        $output = preg_replace('@<body.*?>@is', '$0' . PHP_EOL . $url_form, $output, 1, $count);

        // <body> tag was not found, just put the form at the top of the page
        if ($count == 0) {
            $output = $url_form . $output;
        }

        $response->setContent($output);
    }
}
