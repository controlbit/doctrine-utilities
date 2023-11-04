<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Service;

use ControlBit\DoctrineUtils\Contract\TypedRepositoryFactoryInterface;
use ControlBit\DoctrineUtils\Exception\RuntimeException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;

final class TypedRepositoryFactory implements TypedRepositoryFactoryInterface
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    public function create(string $typeHintInterfaceOrClass): TypedRepository
    {
        $repositories = [];
        foreach ($this->managerRegistry->getManagers() as $manager) {
            $allEntitiesMetadata = $manager->getMetadataFactory()->getAllMetadata();

            foreach ($allEntitiesMetadata as $metadata) {
                if (!$this->doesHaveType($metadata, $typeHintInterfaceOrClass)) {
                    continue;
                }

                $repositories[] = $manager->getRepository($metadata->getName());
            }
        }

        if (0 === \count($repositories)) {
            throw new RuntimeException(
                sprintf(
                    'There is not repository for type-hinted entity: "%s" .',
                    $typeHintInterfaceOrClass
                )
            );
        }

        return new TypedRepository($repositories);
    }

    /**
     * @param  ClassMetadata<object>  $metadata
     */
    private function doesHaveType(ClassMetadata $metadata, string $typeHint): bool
    {
        if ($metadata->getReflectionClass()->implementsInterface($typeHint)) {
            return true;
        }

        if (\is_a($metadata->getName(), $typeHint)) { // @phpstan-ignore-line
            return true;
        }

        return false;
    }
}