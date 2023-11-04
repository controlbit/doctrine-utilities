<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Resources\App\Entity;

use ControlBit\DoctrineUtils\Contract\UuidIdentifiableInterface;
use ControlBit\DoctrineUtils\Tests\Resources\App\Abstracts\EntityAbstractClass;
use ControlBit\DoctrineUtils\Tests\Resources\App\Contract\SampleInterface;
use ControlBit\DoctrineUtils\Traits\UuidIdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
final class Sample
    extends EntityAbstractClass
    implements SampleInterface, UuidIdentifiableInterface
{
    use UuidIdentifiableTrait;

    #[ORM\Column(type: 'integer', nullable: true)]
    public ?int $number;

    public function __construct(string $uuid = null, ?int $number = null)
    {
        $this->id     = null !== $uuid ? Uuid::fromString($uuid) : Uuid::v7();
        $this->number = $number;
    }

    public function setNumber(?int $number): Sample
    {
        $this->number = $number;

        return $this;
    }
}