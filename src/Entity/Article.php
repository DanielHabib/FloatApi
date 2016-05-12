<?php

namespace FloatApi\Entity;

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
     * @param $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $author
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
     * @param $ampFileName
     */
    public function setAmpFileName($ampFileName)
    {
        $this->ampFileName = $ampFileName;
    }
}
