<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Traits;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait ContainerAwareDoctrineTypeTrait
{
    private ContainerInterface $container;

    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
