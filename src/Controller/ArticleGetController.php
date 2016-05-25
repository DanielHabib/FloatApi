<?php

namespace FloatApi\Controller;


use FloatApi\Hydrator\ArticleHydrator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use FloatApi\Writer\SimpleWriter;
use Doctrine\ORM\EntityManager;
use Twig_Environment;
use FloatApi\Serializer\ArticleSerializer;

class ArticleGetController extends AbstractController
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
     * @var ArticleSerializer
     */
    protected $articleSerializer;

    /**
     * @param EntityManager     $em
     * @param Twig_Environment  $twig
     * @param SimpleWriter      $simpleWriter
     * @param ArticleHydrator   $articleHydrator
     * @param ArticleSerializer $articleSerializer
     */
    public function __construct(
        EntityManager $em,
        Twig_Environment $twig,
        SimpleWriter $simpleWriter,
        ArticleHydrator $articleHydrator,
        ArticleSerializer $articleSerializer
    ) {
        $this->em = $em;
        $this->twig = $twig;
        $this->simpleWriter = $simpleWriter;
        $this->articleHydrator = $articleHydrator;
        $this->articleSerializer = $articleSerializer;
    }

    public function getArticlesForUser(Request $request, Response $response, $args = [])
    {
        $data = $this->getBody($request);

        $userId = $data['userId'];



    }
}
