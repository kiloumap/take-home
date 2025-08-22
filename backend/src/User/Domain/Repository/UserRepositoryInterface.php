<?php
declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\UserId;
use App\User\Domain\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $userId): ?User;

    public function findByEmail(Email $email): ?User;

    public function delete(User $user): void;

    /**
     * @return User[]
     */
    public function findAll(): array;
}