<?php

use Doctrine\Common\EventManager;
use League\Container\ContainerInterface;
use Whoops\Run;
use FloatApi\Controller\SimpleController;
use FloatApi\Writer\SimpleWriter;
//use ExampleController;

use Refinery29\Piston\Router\RouteGroup;
//$response->setResult()

require 'vendor/autoload.php';
require_once 'src/Controller/SimpleController.php';
require_once 'src/Controller/AbstractController.php';
require_once 'src/Writer/SimpleWriter.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

const TWIG = 'twig';

const CONTEXT_AMP = 'amp';
const FILE_NAME_TEMPLATE_PREFIX = 'templates/';
const FILE_NAME_SIMPLE_AMP = 'amp/simple_%d.html';
const TEMPLATE_SIMPLE_AMP = 'simple_amp.html';

const FILE_NAME_INCREMENTER = 'inc.txt';

const TEMPLATE_COLLECTION = [TEMPLATE_SIMPLE_AMP];
const TEMPLATE_CONTEXT_MAPPING = ['amp' => FILE_NAME_SIMPLE_AMP];

// Container
$container = new League\Container\Container;
$container->share('response', Zend\Diactoros\Response::class);
$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});
$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);
$container->share(SimpleWriter::class);
$container->share(TWIG, function(){
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader);
    return $twig;
});
$container->share(SimpleController::class)
            ->withArgument(TWIG)
            ->withArgument(SimpleWriter::class);
// Routes
$route = new League\Route\RouteCollection($container);
$route->get('/articles/{context:word}/{id:number}', SimpleController::class . '::renderPage');
$route->post('/articles', SimpleController::class . '::createPage');
$route->map('OPTIONS', '/articles', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');

});

// Fire Request
$response = $route->dispatch($container->get('request'), $container->get('response'));
$container->get('emitter')->emit($response);
