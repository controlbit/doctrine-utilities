<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests;

use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\WithCurrencyEntity;
use ControlBit\DoctrineUtils\Types\CurrencyType;
use ControlBit\DoctrineUtils\ValueObject\Currency;
use Doctrine\ORM\EntityManagerInterface;

final class CurrencyTypeTest extends KernelTestCase
{
    public function testEntityTypeRetrieve(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager    = self::getContainer()->get(EntityManagerInterface::class);
        $entity = $entityManager->find(WithCurrencyEntity::class, '1ae96338-d639-4fa8-9712-4f9b250aefd8');


        self::assertInstanceOf(Currency::class, $entity->getCurrency());
        self::assertEquals('EUR', (string)$entity->getCurrency());
    }

    public function testCurrencyTypeName(): void
    {
        self::assertEquals('currency', (new CurrencyType())->getName());
    }

    public function testCurrencyLocalizedName(): void
    {
        self::assertEquals('Euro', (new Currency('EUR'))->getLocalizedName());
    }
}