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

namespace ProxyApp\Controller;

use Exception;
use Kraber\Http\Message\Response;
use Proxy\Config;
use Proxy\Http\Request;
use Proxy\Proxy;
use ProxyApp\Controller\Interfaces\ControllerInterface;
use ProxyApp\Exceptions\TemplateMissingException;
use Psr\Http\Message\ResponseInterface;

final class RunProxyController extends Controller implements ControllerInterface
{

    /**
     * @throws TemplateMissingException
     */
    public function __invoke(): ResponseInterface
    {
        /** decode q parameter to get the real URL */
        $url = url_decrypt($_GET['q']);

        /** @var Proxy $proxy */
        $proxy = new Proxy();

        /**
         * Load the Plugins
         */
        foreach (Config::get('plugins', []) as $plugin) {

            $plugin_class = $plugin . 'Plugin';

            if (file_exists('./plugins/' . $plugin_class . '.php')) {

                // use user plugin from /plugins/
                require_once('./plugins/' . $plugin_class . '.php');

            } elseif (class_exists('\\Proxy\\Plugin\\' . $plugin_class)) {

                // does the native plugin from php-proxy package with such name exist?
                $plugin_class = '\\Proxy\\Plugin\\' . $plugin_class;
            } elseif (class_exists('\\ProxyApp\\Plugins\\' . $plugin_class)) {

                // does the native plugin from php-proxy package with such name exist?
                $plugin_class = '\\ProxyApp\\Plugins\\' . $plugin_class;
            }

            // otherwise plugin_class better be loaded already through composer.json and match namespace exactly \\Vendor\\Plugin\\SuperPlugin
            // $proxy->getEventDispatcher()->addSubscriber(new $plugin_class());

            $proxy->addSubscriber(new $plugin_class(renderHelper: $this->getRenderHelper()));
        }

        try {

            // request sent to index.php
            $request = Request::createFromGlobals();

            // remove all GET parameters such as ?q=
            $request->get->clear();

            // if that was a streaming response, then everything was already sent and script will be killed before it even reaches this line
            $response = new Response();

            $response->getBody()->write(
                ($proxy->forward($request, $url))->send()
            );

            return $response;

        } catch (Exception $ex) {

            // if the site is on server2.proxy.com then you may wish to redirect it back to proxy.com
            if (Config::get("error_redirect")) {

                $url = render_string(Config::get("error_redirect"), array(
                    'error_msg' => rawurlencode($ex->getMessage())
                ));

                // Cannot modify header information - headers already sent
                header("HTTP/1.1 302 Found");
                header("Location: {$url}");

                $response = new Response();
                $response->withStatus(302);
                $response->withHeader('Location', $url);

                return $response;
            } else {

                return $this->render('main', [
                    'url'       => $url,
                    'error_msg' => $ex->getMessage()
                ]);

            }
        }


    }
}