<?php
declare(strict_types=1);

namespace App\Product\Domain\Enum;

enum BillingPeriod: string
{
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case WEEKLY = 'weekly';
    case LIFETIME = 'lifetime';

    public function getLabel(): string
    {
        return match($this) {
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
            self::WEEKLY => 'Weekly',
            self::LIFETIME => 'Lifetime',
        };
    }

    public function getDurationInDays(): ?int
    {
        return match($this) {
            self::WEEKLY => 7,
            self::MONTHLY => 30,
            self::YEARLY => 365,
            self::LIFETIME => null,
        };
    }

    public function getDisplayName(): string
    {
        return match($this) {
            self::MONTHLY => 'per month',
            self::YEARLY => 'per year',
            self::WEEKLY => 'per week',
            self::LIFETIME => 'one-time',
        };
    }
}