<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Service;

use Doctrine\Persistence\ObjectRepository;

final class TypedRepository
{
    /**
     * @param  ObjectRepository<Object>[]  $repositories
     */
    public function __construct(
        private readonly array $repositories,
    ) {
    }

    public function findByIdentifier(string|int $id): ?object
    {
        foreach ($this->repositories as $repository) {
            $result = $repository->find($id);

            if (null !== $result) {
                return $result;
            }
        }

        return null;
    }
}