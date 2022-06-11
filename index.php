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

/** Force Debug Mode (overwrites config in .env) */
const DEBUG = true;

/** Route the request to the bootstrap-file */
include 'src/Boostrap.php';
