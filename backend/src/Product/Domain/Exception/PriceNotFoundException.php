<?php
declare(strict_types=1);


namespace App\Product\Domain\Exception;

use DomainException;
use Throwable;

class PriceNotFoundException extends DomainException
{
    public function __construct(string $productName = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Incorrect price for product %s', $productName), $code, $previous);
    }
}