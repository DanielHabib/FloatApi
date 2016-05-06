<?php

use Dotenv\Dotenv;
use League\Container\Container;
//use Refinery29\Environment\Environment;
//use Refinery29\NewRelic;
//use Refinery29\FloatApi\ServiceProvider;
use Whoops\Handler;
use Whoops\Run;

ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controller/SimpleController.php';
$envPath = './';
//$proxyPath = getenv('ZEP_PROXY_DIR') ?: null;

if (!getenv('SKIP_DOTENV')) {
    $dotEnv = new Dotenv(__DIR__);

    $dotEnv->load();
    $dotEnv->required([
        'FLOAT_ENV',
    ]);
}

$container = new Container();

//$container->addServiceProvider(new ServiceProvider\DBALMigrationConfigurationServiceProvider());
//$container->addServiceProvider(new ServiceProvider\MonologServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ControllerServiceProvider());
//$container->addServiceProvider(new ServiceProvider\FractalManagerServiceProvider());
//$container->addServiceProvider(new ServiceProvider\RepositoryServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ResourceBuilderServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ScopeBuilderServiceProvider());
//$container->addServiceProvider(new ServiceProvider\SolrServiceProvider());
//$container->addServiceProvider(new ServiceProvider\TransformerContainerServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ValidatorServiceProvider());
//$container->addServiceProvider(new ServiceProvider\RedisServiceProvider());
//$container->addServiceProvider(new ServiceProvider\MiddlewareServiceProvider());
//$container->addServiceProvider(new ServiceProvider\HydratorServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ListenerServiceProvider(getenv('FOUNDRY_HOST')));
//$container->addServiceProvider(new ServiceProvider\UrlBuilderServiceProvider());
//$container->addServiceProvider(new ServiceProvider\EventServiceProvider());
//$container->addServiceProvider(new ServiceProvider\NewRelicServiceProvider());
//$container->addServiceProvider(new ServiceProvider\EnvironmentServiceProvider());
//$container->addServiceProvider(new ServiceProvider\ApplicationServiceProvider());
//$container->addServiceProvider(new ServiceProvider\UrlBuilderServiceProvider());
//$container->addServiceProvider(new ServiceProvider\RouteServiceProvider());
//$container->addServiceProvider(new ServiceProvider\Image\UrlServiceProvider(getenv('DEV_DOMAIN')));
//$container->addServiceProvider(new ServiceProvider\SubscriberServiceProvider());
//$container->addServiceProvider(new ServiceProvider\EventSubscriberServiceProvider());
//$container->addServiceProvider(new ServiceProvider\EventManagerServiceProvider());


//$container->share(Run::class, function () use ($container) {
//    $whoops = new Run();
//
//    $whoops->pushHandler(new Handler\PrettyPageHandler());
//
//    $jsonHandler = new Whoops\Handler\JsonResponseHandler();
//
//    $jsonHandler->addTraceToOutput(true);
//
//    $whoops->pushHandler($jsonHandler);
//
//    return $whoops;
//});

//$container->addServiceProvider(new ServiceProvider\EntityManagerServiceProvider(
//    'mysqli',
//    getenv('FLOAT_MYSQL_USER'),
//    getenv('FLOAT_MYSQL_PASSWORD'),
//    getenv('FLOAT_MYSQL_HOST'),
//    getenv('FLOAT_MYSQL_DB_NAME'),
//    getenv('FLOAT_ENTITY_DIR'),
//    $proxyPath ?: getenv('ZEP_PROXY_DIR')
//));

return $container;
