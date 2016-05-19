<?php

namespace FloatApi\Controller;

use FloatApi\Entity\Article;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FloatApi\Writer\SimpleWriter;
use Twig_Environment;

class SimpleController extends AbstractController
{

    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var SimpleWriter
     */
    protected $simpleWriter;

    /**
     * @param Twig_Environment $twig
     * @param SimpleWriter     $simpleWriter
     */
    public function __construct(Twig_Environment $twig, SimpleWriter $simpleWriter)
    {
        $this->twig = $twig;
        $this->simpleWriter = $simpleWriter;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function renderPage(Request $request, Response $response, $args = [])
    {
        $id = $args['id'];
        $context = $args['context'];

        //AMP
        $templateMapping = self::TEMPLATE_CONTEXT_MAPPING;
        $template = $this->twig->render(sprintf($templateMapping[$context], $id));

        //TODO Apple News
        //TODO RSS

        $response->getBody()->write($template);

        return $response;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return \Psr\Http\Message\MessageInterface
     */
    public function createPage(Request $request, Response $response, $args = [])
    {
        $authorized = $this->checkAuth($request);
        if (!$authorized) {
            return $response->withStatus(401, self::ERROR_MESSAGE_UNAUTHORIZED);
        }
        $user =

        // Decode Request
        $body = $this->getBody($request);

        $number = $this->getInc();

        // AMP
        $ampFileName = $this->simpleWriter->writeAMPPage(
            $this->twig,
            $number,
            $body);

        //Facebook Instant
        $fbFileName = $this->simpleWriter->writeFBPage($number, $body);

        // Create an article object
        $article = new Article();
        $article->setAmpFileName($ampFileName);
        $article->setFbFileName($fbFileName);

        // Serialize
        $responseJSON = json_encode(['id' => $number]);

        // Return Response
        return $this->writeResponse($response, $responseJSON);
    }
}
