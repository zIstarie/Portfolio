<?php

namespace Portfolio\Config;

use Dotenv\Dotenv as DotenvConfig;

class Dotenv
{
    public static function config(): array
    {
        $dotenv = DotenvConfig::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();

        return $_ENV;
    }
}

?>