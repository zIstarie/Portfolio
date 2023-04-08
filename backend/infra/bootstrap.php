<?php

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Portfolio\Config\Dotenv;

const ENV = Dotenv::config();

$paths = ['./entities'];
$dbParams = [
    'driver' => ENV['DB_DRIVER'],
    'user' => ENV['DB_USER'],
    'password' => ENV['DB_PASS'],
    'dbname' => ENV['DB_NAME']
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, false);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

?>