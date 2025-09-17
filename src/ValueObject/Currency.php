<?php

declare(strict_types=1);

namespace ControlBit\DoctrineUtils\ValueObject;

use ControlBit\DoctrineUtils\Exception\LogicException;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Currencies;

final readonly class Currency implements \Stringable
{
    private string $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function getValue(): string
    {
        return $this->currency;
    }

    public function getLocalizedName(?string $locale = null): string
    {
        if (!class_exists(Intl::class)) {
            throw new LogicException(
                \sprintf(
                    'The "symfony/intl" component is required to use "%s::%s". Try running "composer require symfony/intl".',
                    self::class,
                    __FUNCTION__
                )
            );
        }

        return Currencies::getName($this->currency, $locale);
    }

    public function __toString(): string
    {
        return $this->currency;
    }
}