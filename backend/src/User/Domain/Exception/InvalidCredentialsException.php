<?php
declare(strict_types=1);


namespace App\User\Domain\Exception;

use DomainException;
use Throwable;

class InvalidCredentialsException extends DomainException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Registration failed'), $code, $previous);
    }
}