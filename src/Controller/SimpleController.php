<?php

namespace FloatApi\Controller;

use FloatApi\Entity\Article;
use FloatApi\Hydrator\ArticleHydrator;
use FloatApi\Repository\ArticleRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FloatApi\Writer\SimpleWriter;
use Doctrine\ORM\EntityManager;
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
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ArticleHydrator
     */
    protected $articleHydrator;

    /**
     * @param EntityManager $em
     * @param Twig_Environment $twig
     * @param SimpleWriter $simpleWriter
     * @param ArticleHydrator $articleHydrator
     */
    public function __construct(
        EntityManager $em,
        Twig_Environment $twig,
        SimpleWriter $simpleWriter,
        ArticleHydrator $articleHydrator)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->simpleWriter = $simpleWriter;
        $this->articleHydrator = $articleHydrator;
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
        $data['fbFileName'] = $fbFileName;
        $data['ampFileName'] = $ampFileName;
        // Hydrate
        $article = $this->articleHydrator->hydrate($data);

        // Serialize
        $this->em->persist($article);
        $this->em->flush();

        $responseJSON = json_encode(['id' => $number]);

        // Return Response
        return $this->writeResponse($response, $responseJSON);
    }
}
