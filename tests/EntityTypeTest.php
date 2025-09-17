<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests;

use ControlBit\DoctrineUtils\Exception\RuntimeException;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\Sample;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\WithTypeEntity;
use ControlBit\DoctrineUtils\Types\EntityType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;

final class EntityTypeTest extends KernelTestCase
{
    public function testEntityTypeRetrieve(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager    = self::getContainer()->get(EntityManagerInterface::class);
        $entityWithEntity = $entityManager->find(WithTypeEntity::class, '018d2d67-4a17-743f-aef7-b14ab20352e6');

        $entity = $entityWithEntity->getEntity(); // @phpstan-ignore-line

        self::assertInstanceOf(Sample::class, $entity);
        self::assertEquals('018d2d66-f450-7996-9589-266165625a37', $entity->getId()?->toRfc4122());
    }

    public function testEntityTypeName(): void
    {
        self::assertEquals('entity', (new EntityType())->getName());
    }

    #[DataProvider('convertToPHPValueDataProvider')]
    public function testConvertToPHPValue(string $value): void
    {
        $platform = $this->createMock(AbstractPlatform::class);

        $this->expectException(RuntimeException::class);

        (new EntityType())->convertToPHPValue($value, $platform);
    }

    /**
     * @return array<array{string}>
     */
    public static function convertToPHPValueDataProvider(): array
    {
        return [
            ['foo'],
            ['foo::'],
            ['::bar'],
            ['foo::bar'],
        ];
    }
}