<?php

namespace FloatApi\Entity;

use FloatApi\Behavior;

/**
 * @Entity(repositoryClass="FloatApi\Repository\ArticleRepository")
 * @HasLifecycleCallbacks
 * @Table(name="articles")
 **/
class Article
{
    use Behavior\Entity\Date\HasCreatedDate;
    use Behavior\Entity\Date\HasUpdatedDate;
    use Behavior\Entity\HasId;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $headline;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $ampFileName;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $fbFileName;

    /**
     * @Column(
     *     name="user_id",
     *     type="integer",
     *     length=11,
     *     nullable=true,
     *     options={"unsigned":true}
     * )
     *
     * @var int
     */
    protected $userId;

    /**
     * @ManyToOne(
     *     targetEntity="FloatApi\Entity\User",
     *     cascade={"persist"}
     * )
     * @JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id"
     * )
     *
     * @var User
     */
    protected $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param string $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param user $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAmpFileName()
    {
        return $this->ampFileName;
    }

    /**
     * @param string $ampFileName
     */
    public function setAmpFileName($ampFileName)
    {
        $this->ampFileName = $ampFileName;
    }
    /**
     * @return string
     */
    public function getFbFileName()
    {
        return $this->fbFileName;
    }

    /**
     * @param string $fbiaFileName
     */
    public function setFbFileName($fbiaFileName)
    {
        $this->fbFileName = $fbiaFileName;
    }
}
