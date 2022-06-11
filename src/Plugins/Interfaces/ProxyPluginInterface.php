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

namespace ProxyApp\Plugins\Interfaces;

use ProxyApp\Helper\RenderHelper;

interface ProxyPluginInterface {
    public function __construct(RenderHelper $renderHelper);
    public function getRenderHelper() : RenderHelper;
}