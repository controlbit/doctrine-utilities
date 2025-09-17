<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Contract;

use Symfony\Component\DependencyInjection\ContainerInterface;

interface ContainerAwareDoctrineTypeInterface
{
    public function setContainer(ContainerInterface $container): self;

    public function getName(): string;
}