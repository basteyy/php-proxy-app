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

use Kraber\Http\Factory\RequestFactory;
use Kraber\Http\Message\Response;
use Kraber\Http\Message\ServerRequest;
use Proxy\Proxy;
use ProxyApp\Exceptions\TemplateMissingException;
use ProxyApp\Helper\RenderHelper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller {

    /** @var ServerRequestInterface */
    protected ServerRequestInterface $request;

    /** @var ResponseInterface */
    protected ResponseInterface $response;

    /** @var RenderHelper  */
    private RenderHelper $renderHelper;

    public function __construct(
        ServerRequestInterface $request,
        ?ResponseInterface $response = null)
    {
        $this->request = $request;

        if($response) {
            $this->response = $response;
        }
    }

    /**
     * Render a template
     * @param string $template_name
     * @param array|null $template_data
     * @param ResponseInterface|null $response
     * @return ResponseInterface
     * @throws TemplateMissingException
     */
    protected function render(
        string $template_name,
        ?array $template_data = [],
        ?ResponseInterface $response = null
    ) : ResponseInterface {

        if(!$response) {
            $response = $this->response ?? new Response();
        }

        // Put Default Data to the template
        if(!isset($template_data['version'])) {
            $template_data['version'] = Proxy::VERSION;
        }

        $response->getBody()->write(
            $this->getRenderHelper()->render($template_name, $template_data)
        );

        return $response;
    }

    /**
     * Get the Render Helper
     * @return RenderHelper
     */
    protected function getRenderHelper() : RenderHelper {

        if(!isset($this->renderHelper)) {
            $this->renderHelper = new RenderHelper();
        }

        return $this->renderHelper;
    }
}