<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Portfolio\Config\Dotenv;
use Doctrine\ORM\EntityManager as ORMEntityManager;

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

$entityManager = new ORMEntityManager($connection, $config);

?>
