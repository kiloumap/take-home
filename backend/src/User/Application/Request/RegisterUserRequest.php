<?php
declare(strict_types=1);

namespace App\User\Application\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class RegisterUserRequest
{
    public function __construct(
        #[Assert\Email]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6)]
        public string $password,
    ) {}
}