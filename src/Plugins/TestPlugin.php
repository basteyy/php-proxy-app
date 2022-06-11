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

use Proxy\Event\ProxyEvent;
use Proxy\Plugin\AbstractPlugin;
use ProxyApp\Plugins\Interfaces\ProxyPluginInterface;

class TestPlugin extends AbstractPlugin implements ProxyPluginInterface
{
    public function onBeforeRequest(ProxyEvent $event)
    {
        // fired right before a request is being sent to a proxy
    }

    public function onHeadersReceived(ProxyEvent $event)
    {
        // fired right after response headers have been fully received - last chance to modify before sending it back to the user
    }

    public function onCurlWrite(ProxyEvent $event)
    {
        // fired as the data is being written piece by piece
    }

    public function onCompleted(ProxyEvent $event)
    {
        // fired after the full response=headers+body has been read - will only be called on "non-streaming" responses
    }
}