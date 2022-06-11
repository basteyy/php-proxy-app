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

class PortalPlugin extends AbstractPlugin implements ProxyPluginInterface
{
    public function onCompleted(ProxyEvent $event)
    {

    }
}
