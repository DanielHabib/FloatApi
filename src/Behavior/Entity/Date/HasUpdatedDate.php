<?php

namespace FloatApi\Behavior\Entity\Date;

use DateTime;

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
     * @PrePersist
     * @PreUpdate
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
