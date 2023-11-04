<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Types;

use ControlBit\DoctrineUtils\Exception\RuntimeException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class EntityType extends Type
{
    public const  NAME      = 'entity';
    private const SEPARATOR = '::';
    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getName()
    {
        return self::NAME;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);

    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param  string  $value
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!\str_contains($value, self::SEPARATOR)) {
            throw new RuntimeException(
                \sprintf('"%s" does seem to by representation of entity. Wrong format', $value)
            );
        }

        [$entityClass, $identifier] = \explode(self::SEPARATOR, $value);

        if (empty($entityClass) || empty($identifier)) {
            throw new RuntimeException(
                \sprintf('"%s" does seem to by representation of entity. Class or Identifier empty.', $value)
            );
        }

        if (!\class_exists($entityClass)) {
            throw new RuntimeException(
                \sprintf('Namespace "%s" not found by DBAL Entity Type of "%s".', $entityClass, $value)
            );
        }

        return $this->getEntity($entityClass, $identifier);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!\is_object($value)) {
            throw new RuntimeException('Provided value for DBAl conversion for type Entity is not object');
        }

        $entityClass = \get_class($value);

        $entityManager = $this->getEntityManagerForClass($entityClass);
        $classMetaData = $entityManager->getClassMetadata($entityClass);
        $idFieldName   = $classMetaData->getSingleIdentifierFieldName();

        $reflectionObject = new \ReflectionObject($value);
        /** @var string|int $identifier */
        $identifier = $reflectionObject->getProperty($idFieldName)->getValue($value);

        return \sprintf('%s%s%s', $entityClass, self::SEPARATOR, $identifier);
    }

    /**
     * @param  class-string  $entityClass
     */
    private function getEntity(string $entityClass, string|int $identifier): ?object
    {
        return $this->getEntityManagerForClass($entityClass)->find($entityClass, $identifier);
    }

    /**
     * @param  class-string  $entityClass
     */
    private function getEntityManagerForClass(string $entityClass): EntityManagerInterface
    {
        /** @var Registry $managerRegistry */
        $managerRegistry = $this->container->get('doctrine');
        /** @var EntityManagerInterface|null $entityManager */
        $entityManager = $managerRegistry->getManagerForClass($entityClass);

        if (null === $entityManager) {
            throw new RuntimeException(\sprintf('Seems there is not manager for Entity Class "%s"', $entityClass));
        }

        return $entityManager;
    }
}