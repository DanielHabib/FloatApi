<?php

namespace FloatApi\Behavior;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait HasCreatedDate
{
    /**
     * @ORM\Column(
     *     type="datetime",
     *     name="created",
     *     nullable=false
     * )
     *
     * @Solr\Field(name="created_dt")
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * @ORM\PrePersist
     */
    public function updateCreated()
    {
        if ($this->createdDate !== null) {
            return;
        }

        $this->createdDate = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        if ($this->createdDate === null) {
            return;
        }

        return clone $this->createdDate;
    }
}
