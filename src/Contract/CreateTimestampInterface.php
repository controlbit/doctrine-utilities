<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Contract;

/**
 * Contracting that entity implementing this support timestamp of itself
 */
interface CreateTimestampInterface
{
    public function setCreatedAt(\DateTimeInterface $dateTime): CreateTimestampInterface;

    public function getCreatedAt(): ?\DateTimeInterface;
}
