<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator as SymfonyUuidGenerator;
use Symfony\Component\Uid\Uuid;

final class UuidGenerator extends AbstractIdGenerator
{
    public function __construct(private readonly SymfonyUuidGenerator $uuidGenerator)
    {
    }

    public function generate(EntityManager $entityManager, $entity) // @phpstan-ignore-line
    {
        return $this->generateId($entityManager, $entity); // @phpstan-ignore-line
    }

    /**
     * @param object|null $entity
     */
    public function generateId(EntityManagerInterface $entityManager, $entity): mixed
    {
        if (null === $entity) {
            return null;
        }

        $metadata = $entityManager->getClassMetadata(\get_class($entity));
        $value    = $metadata->getSingleIdReflectionProperty()?->getValue($entity);

        if (empty($value)) {
            return $this->uuidGenerator->generateId($entityManager, $entity);
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        throw new \InvalidArgumentException(
            \sprintf("If you manually set UUID it should be instance of %s", Uuid::class)
        );
    }

    public function isPostInsertGenerator(): bool
    {
        return $this->uuidGenerator->isPostInsertGenerator();
    }
}