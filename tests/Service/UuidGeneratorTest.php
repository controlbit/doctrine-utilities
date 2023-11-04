<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Service;

use ControlBit\DoctrineUtils\Service\UuidGenerator;
use ControlBit\DoctrineUtils\Tests\KernelTestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Uid\Uuid;

class UuidGeneratorTest extends KernelTestCase
{
    private UuidGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var UuidGenerator $generator */
        $this->generator = self::getContainer()->get('doctrine.uuid_generator');
    }

    /**
     * @dataProvider generateIdDataProvider
     */
    public function testGenerateIdWhenReflectionPropertyEntityValueIsNull(
        ?object              $entity,
        string|Uuid|null     $reflectionPropertyValue,
        bool|Uuid|\Throwable $expected,
    ): void {


        $entityManagerMock      = $this->createMock(EntityManager::class);
        $mappingMetadataMock    = $this->createMock(ClassMetadata::class);
        $reflectionPropertyMock = $this->createMock(\ReflectionProperty::class);

        $mappingMetadataMock->method('getSingleIdReflectionProperty')->willReturn($reflectionPropertyMock);
        $reflectionPropertyMock->method('getValue')->willReturn($reflectionPropertyValue);
        $entityManagerMock->method('getClassMetadata')->willReturn($mappingMetadataMock);

        if ($expected instanceof \Throwable) {
            $this->expectException(\get_class($expected));
        }

        $output = $this->generator->generate($entityManagerMock, $entity);

        if (\is_bool($expected)) {
            $expected ? self::assertNull($output) : self::assertNotNull($output);

            return;
        }

        self::assertEquals($expected, $output);
    }

    /**
     * @return iterable<string, array{object|null, string|null, bool|\Throwable}
     */
    public function generateIdDataProvider(): iterable
    {
        yield 'Entity is null' => [
            null,
            null,
            true, // is return value null or not?
        ];

        yield 'Reflection Value is null' => [
            new \stdClass(),
            null,
            false,
        ];

        yield 'Reflection Value is empty string' => [
            new \stdClass(),
            '',
            false,
        ];

        yield 'Reflection Value is string' => [
            new \stdClass(),
            'foo',
            new \InvalidArgumentException(),
        ];

        $uuid = new Uuid('0198b226-58ae-79b4-907e-7ece28409564');

        yield 'Reflection Value is UUID' => [
            new \stdClass(),
            $uuid,
            $uuid,
        ];
    }

    public function testIsPostInsertGenerator(): void
    {
        self::assertFalse($this->generator->isPostInsertGenerator());
    }
}