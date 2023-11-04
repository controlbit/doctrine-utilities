<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests;

use ControlBit\DoctrineUtils\Exception\RuntimeException;
use ControlBit\DoctrineUtils\Service\TypedRepositoryFactory;
use ControlBit\DoctrineUtils\Tests\Resources\App\Contract\SampleInterface;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\Sample;
use Doctrine\ORM\EntityManagerInterface;

final class FactoryTest extends KernelTestCase
{
    public function testCreate(): void
    {
        /** @var TypedRepositoryFactory $factory */
        $factory = self::getContainer()->get(TypedRepositoryFactory::class);

        $result = $factory->create(SampleInterface::class)->findByIdentifier('018d2d66-f450-7996-9589-266165625a37');

        self::assertNotNull($result);
        self::assertInstanceOf(Sample::class, $result);
    }

    public function testCreateWhenRepositoryOkButNoEntityFound(): void
    {
        /** @var TypedRepositoryFactory $factory */
        $factory = self::getContainer()->get(TypedRepositoryFactory::class);

        self::assertNull($factory->create(SampleInterface::class)
                                 ->findByIdentifier('018d2dee-d35e-7cb9-ab59-eef1e31d4a02')); // Does not exist
    }

    public function testCreateThrowsErrorWhenNoRepositoryFoundForTypeHint(): void
    {
        /** @var TypedRepositoryFactory $factory */
        $factory = self::getContainer()->get(TypedRepositoryFactory::class);

        $this->expectException(RuntimeException::class);

        $factory->create(EntityManagerInterface::class);
    }
}