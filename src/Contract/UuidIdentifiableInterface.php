<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Contract;

use Symfony\Component\Uid\Uuid;

/**
 * This contract assures that object implementing it uses UUIDs of string type
 */
interface UuidIdentifiableInterface
{
    public function getId(): ?Uuid;
}
