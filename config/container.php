<?php

use Whoops\Handler;
use FloatApi\Writer\SimpleWriter;
use FloatApi\Controller\SimpleController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use FloatApi\Controller\UserController;
use FloatApi\Hydrator;
use FloatApi\Serializer;
use FloatApi\Repository;
use FloatApi\Entity;

ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

const TWIG = 'twig';

$isDevMode = false;
// Container
$container = new League\Container\Container;
$container->share('response', Zend\Diactoros\Response::class);
$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});
$container->share(EntityManager::class, function() use ($isDevMode){

    $connectionParams = array(
        'dbname' => 'mydb',
        'user' => 'user',
        'password' => '7CVzgIrdtQ',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    );
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src"), $isDevMode);
    $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    return EntityManager::create($conn, $config);
});
$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);
$container->share(SimpleWriter::class);
$container->share(TWIG, function(){
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates/');
    $twig = new Twig_Environment($loader);

    return $twig;
});

// Controllers
$container->share(SimpleController::class)
    ->withArgument(TWIG)
    ->withArgument(SimpleWriter::class);
$container->share(Hydrator\UserHydrator::class);
$container->share(Serializer\UserSerializer::class);
$container->share(Repository\UserRepository::class, function() use ($container){
    /** @var EntityManager $em */
    $em = $container->get(EntityManager::class);
    return $em->getRepository(Entity\User::class);
});

$container->share(UserController::class)
    ->withArgument(EntityManager::class)
    ->withArgument(Serializer\UserSerializer::class)
    ->withArgument(Hydrator\UserHydrator::class)
    ->withArgument(Repository\UserRepository::class)
    ;

return $container;