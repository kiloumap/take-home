<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Service;

use App\Product\Domain\Exception\PriceNotFoundException;
use App\Product\Domain\Exception\ProductNotFoundException;
use App\Product\Domain\Model\PricingOption;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Subscription\Domain\Exception\NoActiveSubscriptionException;
use App\Subscription\Domain\Model\Subscription;
use App\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use App\User\Domain\Model\User;
use DateTimeImmutable;

class SubscriptionService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private SubscriptionRepositoryInterface $subscriptionRepository,
    ) {
    }

    public function subscribe(User $user, string $productName, string $pricingOptionName): Subscription
    {
        $product = $this->productRepository->findByName($productName);

        if (!$product) {
            throw new ProductNotFoundException($productName);
        }
        $pricingOption = $product->getPricingOptionByName($pricingOptionName);

        if (!$pricingOption) {
            throw new PriceNotFoundException($productName);
        }

        /** @var ?Subscription $subscription */
        $subscription = $this->subscriptionRepository->findActiveByUserIdAndProductName($user->getId(), $productName);;

        if ($subscription) {
            return $this->extendExistingSubscription($subscription, $pricingOption);
        }

        return $this->createNewSubscription($user, $product, $pricingOption);
    }

    /** @return Subscription[] */
    public function getActiveSubscriptions(User $user): array
    {
        $activeSubscriptions = $this->subscriptionRepository->findActiveByUserId($user->getId());
        if (empty($activeSubscriptions)) {
            throw new NoActiveSubscriptionException();
        }

        return $activeSubscriptions;
    }

    public function cancelActiveSubscription(User $user, string $productName): Subscription
    {
        $product = $this->productRepository->findByName($productName);
        if (!$product) {
            throw new ProductNotFoundException($productName);
        }

        $activeSubscription = $this->subscriptionRepository->findActiveByUserIdAndProductName($user->getId(),
            $productName);

        if ($activeSubscription === null) {
            throw new NoActiveSubscriptionException($productName);
        }

        $activeSubscription->setCancelled(true);
        $this->subscriptionRepository->save($activeSubscription);

        return $activeSubscription;
    }

    private function extendExistingSubscription(Subscription $subscription, PricingOption $pricingOption): Subscription
    {
        $duration = $pricingOption->getBillingDurationInDays();

        if ($duration === null) {
            $subscription->setEndDate(null);
            $this->subscriptionRepository->save($subscription);

            return $subscription;
        }

        $currentEndDate = $subscription->getEndDate() ?? new DateTimeImmutable();
        $newEndDate = $currentEndDate->modify("+{$duration} days");
        $subscription->setEndDate($newEndDate);
        $subscription->setCancelled(false);
        $this->subscriptionRepository->save($subscription);

        return $subscription;
    }

    private function createNewSubscription(User $user, Product $product, PricingOption $pricingOption): Subscription
    {
        $startDate = new DateTimeImmutable();
        $duration = $pricingOption->getBillingDurationInDays();
        $endDate = null;

        if ($duration !== null) {
            $endDate = $startDate->modify("+{$duration} days");
        }

        $subscription = new Subscription($startDate, $user, $pricingOption);
        $subscription->setActive(true);
        $subscription->setEndDate($endDate);
        $this->subscriptionRepository->save($subscription);

        return $subscription;
    }
}
