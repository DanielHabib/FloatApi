<?php

namespace FloatApi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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

        $userId = $data['userId'];
        $articles = $this->articleRepository->getArticlesForUser($userId);
        $serializedArticles = [];

        foreach ($articles as $article) {
            array_push($serializedArticles, $this->articleSerializer->transform($article));
        }

        return $this->writeResponse($response, json_encode($serializedArticles));
    }
}
