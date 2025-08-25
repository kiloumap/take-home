<?php
declare(strict_types=1);


namespace App\Subscription\Application\Request;

use App\Product\Application\Request\PricingOptionData;

readonly class CancelRequest
{
    public function __construct(
        public string $productName,
    ) {
    }
}