<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Tests\Resources\App\Entity;

use ControlBit\DoctrineUtils\Contract\UuidIdentifiableInterface;
use ControlBit\DoctrineUtils\Traits\UuidIdentifiableTrait;
use ControlBit\DoctrineUtils\ValueObject\Currency;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
final class WithCurrencyEntity implements UuidIdentifiableInterface
{
    use UuidIdentifiableTrait;

    #[ORM\Column(type: 'currency')]
    public Currency $currency;

    public function __construct(string $uuid, Currency $currency)
    {
        $this->id       = Uuid::fromString($uuid);
        $this->currency = $currency;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}