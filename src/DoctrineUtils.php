<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils;

use ControlBit\DoctrineUtils\Contract\ContainerAwareDoctrineTypeInterface;
use ControlBit\DoctrineUtils\DependencyInjection\Extension;
use ControlBit\DoctrineUtils\Types\CurrencyType;
use ControlBit\DoctrineUtils\Types\EntityType;
use Doctrine\DBAL\Exception;
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
        $this->addDoctrineType(EntityType::class);
        $this->addDoctrineType(CurrencyType::class);
    }

    /**
     * @param  class-string<ContainerAwareDoctrineTypeInterface>  $typeClass
     */
    private function addDoctrineType(string $typeClass): void
    {
        $name = (new $typeClass())->getName();

        if (!Type::hasType($name)) {
            Type::addType($name, $typeClass);
        }

        /** @var ContainerAwareDoctrineTypeInterface $type */
        $type = Type::getType($name);
        $type->setContainer($this->container); // @phpstan-ignore-line
    }

}