<?php

namespace FloatApi\Serializer;

use FloatApi\Behavior\Transformer\Date\TransformsCreatedDate;
use FloatApi\Behavior\Transformer\Date\TransformsUpdatedDate;
use FloatApi\Entity\Article;

class ArticleSerializer implements SerializerInterface
{
    use TransformsCreatedDate;
    use TransformsUpdatedDate;
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

        $this->transformCreatedDate($data, $article->getCreatedDate());
        $this->transformUpdatedDate($data, $article->getUpdatedDate());

        return $data;
    }
}
