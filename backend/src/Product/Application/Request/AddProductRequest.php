<?php
declare(strict_types=1);

namespace App\Product\Application\Request;

readonly class AddProductRequest
{
    public function __construct(
        public string $name,
        public string $description,
        /** @var PricingOptionData[] */
        public mixed $pricingOption,
    ) {
    }
}