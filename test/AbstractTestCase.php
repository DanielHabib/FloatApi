<?php

namespace FloatApi\Test;
use League\Container\Container;

class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    private $container;

    /**
     * @return Container
     */
    protected function getContainer()
    {
        if ($this->container === null) {
            $this->container = require __DIR__ . '/../config/container.php';
        }
        return $this->container;
    }
}
