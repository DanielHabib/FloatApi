<?php
// cli-config.php

use Doctrine\ORM\EntityManager;

$container = require __DIR__ . '/config/container.php';

$entityManager = $container->get(EntityManager::class);


return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);