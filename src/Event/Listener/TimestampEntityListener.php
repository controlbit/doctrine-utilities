<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Event\Listener;

use ControlBit\DoctrineUtils\Contract\CreateTimestampInterface;
use ControlBit\DoctrineUtils\Contract\UpdateTimestampInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

final class TimestampEntityListener
{
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof UpdateTimestampInterface) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof CreateTimestampInterface && null === $entity->getCreatedAt()) {
            $entity->setCreatedAt(new \DateTimeImmutable());
        }
    }
}
