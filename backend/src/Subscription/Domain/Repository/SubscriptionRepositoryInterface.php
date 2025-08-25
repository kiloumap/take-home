<?php
declare(strict_types=1);

namespace App\Subscription\Domain\Repository;

use App\Subscription\Domain\Model\Subscription;
use Symfony\Component\Uid\Uuid;

interface SubscriptionRepositoryInterface
{
    public function save(Subscription $subscription): void;
    /** @return Subscription[]|array{} */
    public function findActiveByUserId(Uuid $userId): array;
    public function findActiveByUserIdAndProductName(Uuid $userId, string $productName): ?Subscription;
}