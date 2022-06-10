<?php

declare(strict_types=1);

namespace ProxyApp\Controller\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ControllerInterface {
    public function __invoke() : ResponseInterface;
}
