<?php

namespace FloatApi\Entity;

use FloatApi\Entity\User;

/**
 * @Entity(repositoryClass="FloatApi\Repository\ArticleRepository")
 *
 * @Entity @Table(name="articles")
 **/
class Article
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     **/
    protected $id;

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
    protected $author;

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
     * @ORM\Column(
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
     * @ORM\ManyToOne(
     *     targetEntity="FloatApi\Entity\User",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
