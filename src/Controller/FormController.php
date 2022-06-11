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