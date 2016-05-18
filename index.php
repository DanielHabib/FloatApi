<?php
use FloatApi\Controller\SimpleController;
use FloatApi\Writer\SimpleWriter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\EntityManager;
use FloatApi\Controller\UserController;

require_once 'vendor/autoload.php';

const CONTEXT_AMP = 'amp';
const CONTEXT_FB = 'fb';
const FILE_NAME_TEMPLATE_PREFIX = 'templates/';
const FILE_NAME_SIMPLE_AMP = 'amp/simple_%d.html';
const FILE_NAME_SIMPLE_FB = 'fb/simple_%d.html';
const TEMPLATE_SIMPLE_AMP = 'simple_amp.html';
const FILE_NAME_INCREMENTER = 'inc.txt';
const TEMPLATE_COLLECTION = [TEMPLATE_SIMPLE_AMP];
const TEMPLATE_CONTEXT_MAPPING = ['amp' => FILE_NAME_SIMPLE_AMP];


// Container
$container = require __DIR__ . '/config/container.php';

// Routes

// Articles
$route = new League\Route\RouteCollection($container);
$route->get('/articles/{context:word}/{id:number}', SimpleController::class . '::renderPage');
$route->post('/articles', SimpleController::class . '::createPage');
$route->map('OPTIONS', '/articles', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');

});

// Users
$route->post('/users', UserController::class . '::createUser');
$route->get('/users/login', UserController::class . '::login');
$route->get('/users/logout', UserController::class . '::logout');
$route->get('/users/{id:number}/articles', UserController::class . '::getArticlesWithUser');
$route->map('OPTIONS', '/users', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');
});

// Fire Request
$response = $route->dispatch($container->get('request'), $container->get('response'));
$container->get('emitter')->emit($response);


