<?php

namespace FloatApi\Behavior\Entity;

trait HasId
{
    /**
     * @Id
     * @Column(
     *     type="integer",
     *     length=11,
     *     options={"unsigned":true}
     * )
     * @GeneratedValue
     *
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
