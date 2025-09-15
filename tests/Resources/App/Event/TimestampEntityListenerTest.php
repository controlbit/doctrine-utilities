<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Resources\App\Event;

use ControlBit\DoctrineUtils\Tests\KernelTestCase;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\Sample;
use Doctrine\ORM\EntityManagerInterface;

final class TimestampEntityListenerTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class); // @phpstan-ignore-line
    }

    public function testCreateTimestamp(): void
    {
        $entity = new Sample();
        self::assertNull($entity->getCreatedAt());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        self::assertInstanceOf(\DateTimeInterface::class, $entity->getCreatedAt());
    }

    public function testUpdateTimestamp(): void
    {
        $entity = new Sample();

        self::assertNull($entity->getUpdatedAt());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        self::assertNull($entity->getUpdatedAt());
        $entity->setNumber(99);

        sleep(1);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        self::assertGreaterThan($entity->getCreatedAt()?->getTimestamp(), $entity->getUpdatedAt()?->getTimestamp());
    }

}