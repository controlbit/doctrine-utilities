<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Resources\App\Entity;

use ControlBit\DoctrineUtils\Contract\UuidIdentifiableInterface;
use ControlBit\DoctrineUtils\Traits\UuidIdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
final class WithTypeEntity implements UuidIdentifiableInterface
{
    use UuidIdentifiableTrait;

    #[ORM\Column(type: 'entity')]
    public object $entity;

    public function __construct(string $uuid, object $entity)
    {
        $this->id     = Uuid::fromString($uuid);
        $this->entity = $entity;
    }

    public function getEntity(): object
    {
        return $this->entity;
    }
}