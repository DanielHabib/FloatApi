<?php

namespace FloatApi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig_Loader_Filesystem;
use Twig_Environment;
class SimpleController
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig){

        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function renderPage(Request $request, Response $response, $args = [])
    {
        $id = $args['id'];
        $template = $this->twig->render(sprintf(FILE_NAME_SIMPLE_AMP, $id));
        $response->getBody()->write($template);
        return $response;
    }
}
