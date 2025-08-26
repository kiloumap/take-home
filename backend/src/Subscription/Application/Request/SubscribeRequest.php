<?php
declare(strict_types=1);

namespace App\Subscription\Application\Request;

readonly class SubscribeRequest
{
    public function __construct(
        public string $productName,
        public string $pricingOptionName,
    ) {
    }
}