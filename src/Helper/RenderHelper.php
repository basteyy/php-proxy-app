<?php

declare(strict_types=1);

namespace ProxyApp\Helper;

use ProxyApp\Exceptions\TemplateMissingException;

final class RenderHelper {

    public function __construct()
    {
    }

    /**
     * @param string $file_path
     * @param array|null $vars
     * @return string
     * @throws TemplateMissingException
     */
    public function render(
        string $file_path,
        ?array $vars = []
    ) : string {

        $file_absolute_path = ROOT . '/src/Templates/' . basename($file_path, '.php') . '.php';

        // variables to be used within that template
        extract($vars);

        ob_start();

        if(!file_exists($file_absolute_path)){
            throw new TemplateMissingException(sprintf('Template %s not found at %s', $file_path, $file_absolute_path));
        }

        include $file_absolute_path;

        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;

    }
}