<?php

namespace FloatApi\Controller;

use Refinery29\Piston\Request;
use Refinery29\Piston\ApiResponse as Response;
use Twig_Loader_Filesystem;
use Twig_Environment;
class SimpleController
{
    public function renderPage(Request $request, Response $response)
    {
        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);

        $foo = $twig->render('amp.html', array('name' => 'Fabien'));
        $responseResult = new Response($foo);
//        $response->setResult()
        return $responseResult;
    }
}
