<?php
declare(strict_types=1);

namespace App\User\Domain\Service;

use App\Shared\Domain\ValueObject\Email;
use App\User\Application\Request\RegisterUserRequest;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

readonly class UserService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function register(RegisterUserRequest $request): User
    {

        $user = new User(new Email($request->email), $request->password);
        $this->userRepository->save($user);

        return $user;
    }
}
