<?php
declare(strict_types=1);

namespace App\Subscription\Infrastructure\Persistence\InMemory\Infrastructure;

use App\Subscription\Domain\Model\Subscription;
use App\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use App\User\Domain\Model\User;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class InMemorySubscriptionRepository implements SubscriptionRepositoryInterface
{
    private array $subscriptions = [];

    public function save(Subscription $subscription): void
    {
        $this->subscriptions[] = $subscription;
    }

    public function findActiveByUser(User $user): array
    {
        return array_filter($this->subscriptions, function (Subscription $sub) use ($user) {
            return $sub->getUser()->getId()->equals($user->getId()) && $sub->isCurrentlyActive();
        });
    }

    public function findActiveByUserId(Uuid $userId): array
    {
        return array_filter($this->subscriptions, function (Subscription $sub) use ($userId) {
            return $sub->getUser()->getId()->equals($userId) && $sub->isCurrentlyActive();
        });
    }

    public function findActiveByUserIdAndProductName(Uuid $userId, string $productName): ?Subscription
    {
        $now = new DateTimeImmutable();

        $filtered = array_filter($this->subscriptions, function (Subscription $sub) use ($userId, $productName, $now) {
            return $sub->getUser()->getId()->equals($userId) &&
                $sub->getProductName() === $productName &&
                $sub->isActive() &&
                !$sub->isCancelled() &&
                $sub->getStartDate() <= $now &&
                ($sub->getEndDate() === null || $sub->getEndDate() >= $now);
        });

        return array_shift($filtered);
    }
}