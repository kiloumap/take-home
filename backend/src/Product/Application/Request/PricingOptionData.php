<?php
declare(strict_types=1);


namespace App\Product\Application\Request;

use App\Product\Domain\Enum\BillingPeriod;

readonly class PricingOptionData
{
    public function __construct(
        public string $name,
        public float $price,
        public BillingPeriod $billingPeriod,
    ) {
    }
}