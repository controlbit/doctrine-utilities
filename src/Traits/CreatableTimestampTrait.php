<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Traits;

use ControlBit\DoctrineUtils\Contract\CreateTimestampInterface;
use Doctrine\ORM\Mapping as ORM;

trait CreatableTimestampTrait
{
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function setCreatedAt(\DateTimeInterface $dateTime): CreateTimestampInterface
    {
        $this->createdAt = $dateTime;

        /** @var CreateTimestampInterface $this */
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
