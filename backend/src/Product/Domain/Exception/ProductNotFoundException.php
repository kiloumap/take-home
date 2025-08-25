<?php
declare(strict_types=1);


namespace App\Product\Domain\Exception;

use DomainException;
use Throwable;

class ProductNotFoundException extends DomainException
{
    public function __construct(string $productName = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Product with name "%s" was not found', $productName), $code, $previous);
    }
}