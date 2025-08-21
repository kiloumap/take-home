<?php
declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;
use const FILTER_VALIDATE_EMAIL;

class Email
{
    public string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf('"%s" is not a valid email address', $email)
            );
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Email $other): bool
    {
        return $this->value === $other->value;
    }
}