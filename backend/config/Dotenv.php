<?php

namespace Portfolio\Config;

class Dotenv
{
    public static function config(): array
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->safeLoad();

        return $_ENV;
    }
}

?>