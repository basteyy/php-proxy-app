<?php

declare(strict_types=1);

namespace ProxyApp\Controller;

use ProxyApp\Controller\Interfaces\ControllerInterface;
use ProxyApp\Exceptions\TemplateMissingException;
use Psr\Http\Message\ResponseInterface;

final class FormController extends Controller implements ControllerInterface {

    /**
     * @throws TemplateMissingException
     */
    public function __invoke(): ResponseInterface
    {
        return $this->render('main');
    }
}