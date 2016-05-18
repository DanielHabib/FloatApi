<?php

namespace FloatApi\Test\Integration\Controller;

use FloatApi\Test\AbstractTestCase;
use FloatApi\Controller\UserController;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

class UserControllerTest extends AbstractTestCase
{

    public function testLogin()
    {
        $userController = $this->getController();

        $request = new Request(); // What type?
        $response = new Response();
        $value = $userController->login($request, $response);
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
