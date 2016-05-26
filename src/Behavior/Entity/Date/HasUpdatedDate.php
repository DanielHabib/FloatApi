<?php

namespace FloatApi\Behavior\Entity\Date;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait HasUpdatedDate
{
    /**
     * @Column(
     *     type="datetime",
     *     nullable=false,
     *     name="updated"
     * )
     *
     * @var DateTime
     */
    protected $updatedDate;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateUpdated()
    {
        $this->updatedDate = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getUpdatedDate()
    {
        if ($this->updatedDate === null) {
            return;
        }

        return clone $this->updatedDate;
    }
}
