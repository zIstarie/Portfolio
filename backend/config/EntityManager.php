<?php

namespace Portfolio\Config;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager as ORMEntityManager;
use Doctrine\ORM\ORMSetup;

class EntityManager
{

    public static function getEntityManager()
    {
        define('ENV', Dotenv::config());

        $paths = [__DIR__ . '/entities'];
        $dbParams = [
            'driver' => ENV['DB_DRIVER'],
            'user' => ENV['DB_USER'],
            'password' => ENV['DB_PASS'],
            'dbname' => ENV['DB_NAME']
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration($paths, false);
        $connection = DriverManager::getConnection($dbParams, $config);

        return new ORMEntityManager($connection, $config);
    }    
}

?>