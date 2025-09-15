<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Traits;

use ControlBit\DoctrineUtils\Contract\UpdateTimestampInterface;
use Doctrine\ORM\Mapping as ORM;

trait UpdatableTimestampTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function setUpdatedAt(\DateTimeInterface $dateTime): UpdateTimestampInterface
    {
        $this->updatedAt = $dateTime;

        /** @var UpdateTimestampInterface $this */
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
