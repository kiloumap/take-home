<?php
declare(strict_types=1);


namespace App\Subscription\Application\Request;

use App\Product\Application\Request\PricingOptionData;

class SubscribeRequest
{
    public function __construct(
        public readonly string $productName,
        public string $pricingOptionName,
    ) {
    }
}