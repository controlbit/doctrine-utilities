<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils;

use ControlBit\DoctrineUtils\DependencyInjection\Extension;
use ControlBit\DoctrineUtils\Types\EntityType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DoctrineUtils extends Bundle
{
    public function getNamespace(): string
    {
        return 'doctrine_utils';
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new Extension();
    }

    public function boot()
    {
        if (!Type::hasType(EntityType::NAME)) {
            Type::addType(EntityType::NAME, EntityType::class);
        }

        /** @var EntityType $type */
        $type = Type::getType(EntityType::NAME);
        $type->setContainer($this->container); // @phpstan-ignore-line
    }

}