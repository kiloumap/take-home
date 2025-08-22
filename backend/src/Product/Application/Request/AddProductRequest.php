<?php
declare(strict_types=1);

namespace App\Product\Application\Request;

class AddProductRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        /** @var PricingOptionData[] */
        public readonly mixed $pricingOption,
    ) {
    }
}