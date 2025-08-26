<?php
declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\InMemory\Infrastructure;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()->toString()] = $user;
    }

    public function findByEmail(Email $email): ?User
    {
        return array_find($this->users, fn($user) => $user->getUserIdentifier() === $email->getValue());
    }

    public function findById(UserId $userId): ?User
    {
        $filtered = array_filter($this->users, function(User $user) use ($userId) {
            return $user->getId()->equals($userId);
        });

        return array_shift($filtered);
    }

    public function delete(User $user): void
    {
        $this->users = array_filter($this->users, function(User $u) use ($user) {
            return !$u->getId()->equals($user->getId());
        });
    }

    public function findAll(): array
    {
        return $this->users;
    }
}
