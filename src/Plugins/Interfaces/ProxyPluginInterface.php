<?php

declare(strict_types=1);

namespace ProxyApp\Plugins\Interfaces;

use ProxyApp\Helper\RenderHelper;

interface ProxyPluginInterface {
    public function __construct(RenderHelper $renderHelper);
    public function getRenderHelper() : RenderHelper;
}