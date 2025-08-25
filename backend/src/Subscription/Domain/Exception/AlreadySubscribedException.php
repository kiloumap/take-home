<?php
declare(strict_types=1);


namespace App\Subscription\Domain\Exception;

use DomainException;
use Throwable;

class AlreadySubscribedException extends DomainException
{
    public function __construct(string $endDate = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('User is already subscribed until %s', $endDate), $code, $previous);
    }
}