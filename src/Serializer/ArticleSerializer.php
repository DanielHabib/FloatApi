<?php

namespace FloatApi\Serializer;

use FloatApi\Entity\Article;

class ArticleSerializer implements SerializerInterface
{
    /**
     * @var UserSerializer
     */
    protected $userSerializer;

    /**
     * @param UserSerializer $userSerializer
     */
    public function __construct(UserSerializer $userSerializer)
    {
        $this->userSerializer = $userSerializer;
    }

    /**
     * @param Article $article
     *
     * @return array
     */
    public function transform($article)
    {
        $data = [
            'id' => $article->getId(),
            'headline' => $article->getHeadline(),
            'ampFileName' => $article->getAmpFileName(),
            'fbFileName' => $article->getFbFileName(),
            'user' => $this->userSerializer->transform($article->getUser()),
        ];

        return $data;
    }
}
