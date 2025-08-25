<?php
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Shared\Domain\ValueObject\Email;
use App\User\Application\Request\RegisterUserRequest;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function register(RegisterUserRequest $request): User
    {
        $user = new User(new Email($request->email));
        $hashedPassword = $this->passwordHasher->hashPassword($user, $request->password);
        $user->setPassword($hashedPassword);
        $this->userRepository->save($user);

        return $user;
    }
}
