<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Contract;

/**
 * Contracting that entity implementing this support timestamp of update on itself
 */
interface UpdateTimestampInterface
{
    public function setUpdatedAt(\DateTimeInterface $dateTime): UpdateTimestampInterface;

    public function getUpdatedAt(): ?\DateTimeInterface;
}
