<?php
declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Doctrine\Type;

use App\Product\Domain\Enum\BillingPeriod;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BillingPeriodType extends Type
{
    public const NAME = 'billing_period';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?BillingPeriod
    {
        if ($value === null) {
            return null;
        }

        return BillingPeriod::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof BillingPeriod) {
            return $value->value;
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}