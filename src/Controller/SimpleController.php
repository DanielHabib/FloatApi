<?php

namespace FloatApi\Controller;

require_once 'src/Controller/AbstractController.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig_Environment;

class SimpleController extends AbstractController
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
        //AMP
        $template = $this->twig->render(sprintf(FILE_NAME_SIMPLE_AMP, $id));
        //TODO FBIA
        //TODO Apple News
        //TODO RSS
        $response->getBody()->write($template);
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\MessageInterface
     */
    public function createPage(Request $request, Response $response, $args = [])
    {
        // Decode Request
        $body = json_decode($request->getBody()->getContents(), true);

        /** @var Twig_Environment $twig */
        // Grab Template using TWIG

        $template = $this->twig->render(TEMPLATE_SIMPLE_AMP, $body);

        // Create File name
        $number = $this->getInc();

        $filename = FILE_NAME_TEMPLATE_PREFIX.sprintf(FILE_NAME_SIMPLE_AMP, $number);

        //Create Template
        $file = fopen($filename, "w");
        fwrite($file, $template);

        $responseJSON = json_encode(['id' => $number]);

        // Return Response
        $response->getBody()->write($responseJSON);

        return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'Content-Type');
    }



}
