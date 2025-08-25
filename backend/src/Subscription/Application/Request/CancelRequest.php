<?php
declare(strict_types=1);


namespace App\Subscription\Application\Request;

use App\Product\Application\Request\PricingOptionData;

class CancelRequest
{
    public function __construct(
        public readonly string $productName,
    ) {
    }
}