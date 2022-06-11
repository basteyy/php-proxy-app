#!/usr/bin/php
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

namespace ProxyApp\bin;

use function basteyy\VariousPhpSnippets\getRandomString;


define("ROOT", dirname(__DIR__, 2));

include ROOT . '/vendor/autoload.php';

final class Setup {

    /**
     * Script which should run after the setup
     * @return void
     * @throws \Exception
     */
    public static function run(\Composer\EventDispatcher\Event $event) {

        $arguments = $event->getArguments();

        $force_regenerate_keys = in_array('--regenerate_keys', $arguments);

        
        $env_file = ROOT . '/.env';
        $env_example_file = ROOT . '/.env.example';

        /** Copy .env.example to .env */
        if(!file_exists(ROOT . '/.env')) {
            if(!file_exists($env_example_file)) {
                throw new \RuntimeException(sprintf('.env-Example not found at %s', $env_example_file));
            }

            copy($env_example_file, $env_file);
        }

        $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $config = file_get_contents($env_file);

        foreach ($lines as $line) {

            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if('APP_KEY' === $name && (strlen($value) < 1 || $force_regenerate_keys === true)) {
                $config = str_replace($name . '=' . $value, $name . '='. self::getRandomString(), $config);
            }

            if('ENCRYPTION_KEY' === $name && (strlen($value) < 1 || $force_regenerate_keys === true)) {
                $config = str_replace($name . '=' . $value, $name . '='. self::getRandomString(32), $config);
            }

            if('DEBUG' === $name) {
                if(in_array('--debug:off', $arguments) || in_array('--debug:on', $arguments)) {
                    $config = str_replace($name . '=' . $value, $name . '='. (in_array('--debug:off', $arguments) ? 'false' : 'true'), $config);
                }
            }

            if('EXPOSE_PHP' === $name) {
                if(in_array('--expose:off', $arguments) || in_array('--expose:on', $arguments)) {
                    $config = str_replace($name . '=' . $value, $name . '='. (in_array('--expose:off', $arguments) ? 'false' : 'true'), $config);
                }
            }


        }

        // Write Config

        file_put_contents($env_file, $config);

        echo $config;


    }

    /**
     * @param int|null $length
     * @return string
     * @throws \Exception
     */
    public static function getRandomString(?int $length = 64):string {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }
}