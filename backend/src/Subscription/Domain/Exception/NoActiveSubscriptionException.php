<?php
declare(strict_types=1);


namespace App\Subscription\Domain\Exception;

use DomainException;
use Throwable;

class NoActiveSubscriptionException extends DomainException
{
    public function __construct(string $productName = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('No active subscription found for product %s.', $productName), $code, $previous);
    }
}