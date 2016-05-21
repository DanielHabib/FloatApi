<?php

namespace FloatApi\Hydrator;

use FloatApi\Entity\Article;
use FloatApi\Repository\ArticleRepository;

class ArticleHydrator implements HydratorInterface
{

    /**
     * @var ArticleRepository
     */
    protected $articleRepository;

    /**
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {

        $this->articleRepository = $articleRepository;
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function hydrate($data)
    {
        if (array_key_exists('id', $data)) {
            /** @var Article $article */
            $article = $this->articleRepository->find($data['id']);

            if (array_key_exists('headline', $data)) {
                $article->setHeadline($data['headline']);
            }
            if (array_key_exists('fbFileName', $data)) {
                $article->setFbFileName($data['fbFileName']);
            }
            if (array_key_exists('ampFileName', $data)) {
                $article->setAmpFileName($data['ampFileName']);
            }

            return $article;
        }

        $article = new Article();
        $article->setAmpFileName($data['ampFileName']);
        $article->setFbFileName($data['fbFileName']);
        $article->setHeadline($data['headline']);

        return $article;
    }
}
