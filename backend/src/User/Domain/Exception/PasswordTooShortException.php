<?php
declare(strict_types=1);


namespace App\User\Domain\Exception;

use DomainException;
use Throwable;

class PasswordTooShortException extends DomainException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('This value is too short. It should have 6 characters or more.'), $code, $previous);
    }
}