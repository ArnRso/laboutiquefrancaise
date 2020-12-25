<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait DateFieldsTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;


    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new DateTime('now'));

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }
}