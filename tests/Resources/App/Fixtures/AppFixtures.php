<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Resources\App\Fixtures;

use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\Sample;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\WithCurrencyEntity;
use ControlBit\DoctrineUtils\Tests\Resources\App\Entity\WithTypeEntity;
use ControlBit\DoctrineUtils\ValueObject\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sampleEntity = new Sample('018d2d66-f450-7996-9589-266165625a37');

        $manager->persist($sampleEntity);
        $manager->flush();

        $withTypeEntity = new WithTypeEntity('018d2d67-4a17-743f-aef7-b14ab20352e6', $sampleEntity);
        $manager->persist($withTypeEntity);
        $manager->flush();

        $withCurrencyEntity = new WithCurrencyEntity('1ae96338-d639-4fa8-9712-4f9b250aefd8', new Currency('EUR'));
        $manager->persist($withCurrencyEntity);
        $manager->flush();
    }
}