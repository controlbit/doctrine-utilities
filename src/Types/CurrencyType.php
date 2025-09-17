<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\Types;

use ControlBit\DoctrineUtils\Contract\ContainerAwareDoctrineTypeInterface;
use ControlBit\DoctrineUtils\Exception\RuntimeException;
use ControlBit\DoctrineUtils\Traits\ContainerAwareDoctrineTypeTrait;
use ControlBit\DoctrineUtils\ValueObject\Currency;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class CurrencyType extends Type implements ContainerAwareDoctrineTypeInterface
{
    use ContainerAwareDoctrineTypeTrait;

    public const  NAME = 'currency';

    /**
     * @codeCoverageIgnore
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);

    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!\is_string($value)) {
            throw new RuntimeException('Currency value must be a string.');
        }

        return new Currency($value);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Currency) {
            throw new RuntimeException(
                \sprintf(
                    'Provided value for DBAl conversion must be instance %s',
                    Currency::class,
                )
            );
        }

        return (string)$value;
    }
}