<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

//reauire file
require_once "src/Entity/Commandes.php";
require_once "src/Entity/Panier.php";
require_once "src/Entity/Product.php";
require_once "src/Entity/User.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);

// or if you prefer XML
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: [__DIR__ . '/config/xml'],
//    isDevMode: true,
//);

// configuring the database connection : mysql

$connectionParams = [
    'dbname' => 'onlinesales',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];
$connection = DriverManager::getConnection($connectionParams);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);

$em = $entityManager;
