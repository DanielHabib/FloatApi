<?php

namespace FloatApi\Repository;

use Doctrine\ORM\EntityRepository;
use FloatApi\Entity\Article;

class ArticleRepository extends EntityRepository
{

    /**
     * @param int $userId
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return array|null
     */
    public function getArticlesForUser($userId)
    {
        $qb = $this->createQueryBuilder('e');

        $qb = $qb
            ->where(
                $qb->expr()->eq(
                    'e.userId',
                    ':userId'
                )
            )
            ->setParameter('userId', $userId)
            ->orderBy('e.created', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $qb->execute();
    }

}
