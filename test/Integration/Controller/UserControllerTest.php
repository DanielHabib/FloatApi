<?php

namespace FloatApi\Test\Integration\Controller;

use FloatApi\Test\AbstractTestCase;
use FloatApi\Controller\UserController;

class UserControllerTest extends AbstractTestCase
{

    public function testLogin()
    {

    }

    public function testLogout()
    {

    }

    public function testCreateUser()
    {

    }
    public function testGetArticlesWithUser()
    {

    }

    /**
     * @return UserController
     */
    private function getController()
    {
        return $this->getContainer()->get(UserController::class);
    }
}
