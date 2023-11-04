<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Contract;

use ControlBit\DoctrineUtils\Service\TypedRepository;

interface TypedRepositoryFactoryInterface
{
    public function create(string $typeHintInterfaceOrClass): TypedRepository;
}