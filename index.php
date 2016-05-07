<?php

use Doctrine\Common\EventManager;
use League\Container\ContainerInterface;
use Whoops\Run;
use FloatApi\Controller\SimpleController;
//use ExampleController;

use Refinery29\Piston\Router\RouteGroup;
//$response->setResult()

require 'vendor/autoload.php';
require_once 'src/Controller/SimpleController.php';


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

const TWIG = 'twig';
const TWIG_AMP = 'twig_amp';

const FILE_NAME_SIMPLE_AMP = 'amp/simple_%d.html';
const FILE_NAME_TEMPLATE_PREFIX = 'templates/';
const FILE_NAME_INCREMENTER = 'inc.txt';
const TEMPLATE_SIMPLE_AMP = 'simple_amp.html';
const TEMPLATE_COLLECTION = [TEMPLATE_SIMPLE_AMP];

function getInc()
{

    $inc = file('inc.txt')[0];
    $inc += 1;
    if (!$inc)
    {
        $inc = 1;
    }
    $file = fopen(FILE_NAME_INCREMENTER, 'w+');
    fwrite($file, $inc);
    return $inc;

}



$container = new League\Container\Container;
$container->share('response', Zend\Diactoros\Response::class);
$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});
$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);


$container->share(TWIG, function(){
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader);
    return $twig;
});
$container->share(SimpleController::class)
            ->withArgument(TWIG);
$route = new League\Route\RouteCollection($container);


$route->get('/amp/{id:number}', SimpleController::class . '::renderPage');

$route->map('POST', '/foo', function (ServerRequestInterface $request, ResponseInterface $response, array $args) use ($container) {
    // Decode Request
    $body = json_decode($request->getBody()->getContents(), true);

    /** @var Twig_Environment $twig */
    // Grab Template using TWIG
    $twig = $container->get(TWIG);
    $template = $twig->render(TEMPLATE_SIMPLE_AMP, $body);

    // Create File name
    $number = getInc();
    $filename = FILE_NAME_TEMPLATE_PREFIX.sprintf(FILE_NAME_SIMPLE_AMP, $number);

    //Create Template
    $file = fopen($filename, "w");
    fwrite($file, $template);

    $responseJSON = json_encode(['id' => $number]);

    // Return Response
    $response->getBody()->write($responseJSON);

    return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');

});
$route->map('OPTIONS', '/foo', function (ServerRequestInterface $request, ResponseInterface $response, array $args) use ($container)  {

    return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');
});

$route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response, array $args) use ($container)  {

    return $response;
});

$route->map('GET', '/foo/{id:number}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) use ($container)  {
    $id = $args['id'];
    $twig = $container->get(TWIG);
    $template = $twig->render(sprintf(FILE_NAME_SIMPLE_AMP, $id));
    $response->getBody()->write($template);
    return $response;
});

$response = $route->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
