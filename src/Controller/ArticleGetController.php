<?php

namespace FloatApi\Controller;

use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use FloatApi\Serializer\ArticleSerializer;
use FloatApi\Repository\ArticleRepository;

class ArticleGetController extends AbstractController
{
    /**
     * @var ArticleSerializer
     */
    protected $articleSerializer;

    /**
     * @var ArticleRepository
     */
    protected $articleRepository;

    /**
     * @param ArticleSerializer $articleSerializer
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        ArticleSerializer $articleSerializer,
        ArticleRepository $articleRepository
    ) {
        $this->articleSerializer = $articleSerializer;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function getArticlesForUser(Request $request, Response $response, $args = [])
    {
        $data = $this->getBody($request);

        $articles = $this->articleRepository->getArticlesForUser($data['userId']);

        $serializedArticles = [];

        foreach ($articles as $article) {
            array_push($serializedArticles, $this->articleSerializer->transform($article));
        }
        if (empty($serializedArticles)) {
            return $this->renderNotFound($response);
        }
        return $this->writeResponse($response, json_encode($serializedArticles));
    }
}
