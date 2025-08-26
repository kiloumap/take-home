<?php

declare(strict_types=1);

namespace App\Subscription\Domain\Service;

use App\Product\Domain\Enum\BillingPeriod;
use App\Product\Domain\Model\PricingOption;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Service\ProductService;
use App\Product\Infrastructure\Exception\PriceNotFoundException;
use App\Product\Infrastructure\Exception\ProductNotFoundException;
use App\Product\Infrastructure\Persistence\InMemory\Infrastructure\InMemoryProductRepository;
use App\Shared\Domain\ValueObject\Email;
use App\Subscription\Domain\Exception\NoActiveSubscriptionException;
use App\Subscription\Domain\Repository\SubscriptionRepositoryInterface;
use App\Subscription\Infrastructure\Persistence\InMemory\Infrastructure\InMemorySubscriptionRepository;
use App\User\Domain\Model\User;
use App\User\Infrastructure\Persistence\InMemory\Infrastructure\InMemoryUserRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SubscriptionServiceTest extends TestCase
{
    private SubscriptionService $service;

    public function setUp(): void
    {
        $userRepo = new InMemoryUserRepository();
        $productRepo = new InMemoryProductRepository();
        $subscriptionRepo = new InMemorySubscriptionRepository();

        $productService = new ProductService($productRepo);
        $this->service = new SubscriptionService($productService, $subscriptionRepo);

        $product = new Product('Phpstorm', 'IDE for PHP');
        $product->addPricingOption(new PricingOption($product, 'monthly', 10, BillingPeriod::MONTHLY));
        $product->addPricingOption(new PricingOption($product, 'yearly', 10, BillingPeriod::YEARLY));
        $product->addPricingOption(new PricingOption($product, 'lifetime', 10, BillingPeriod::LIFETIME));
        $productRepo->save($product);

        $product2 = new Product('Goland', 'IDE for Golang');
        $product2->addPricingOption(new PricingOption($product2, 'monthly', 10, BillingPeriod::MONTHLY));
        $product2->addPricingOption(new PricingOption($product2, 'yearly', 10, BillingPeriod::YEARLY));
        $product2->addPricingOption(new PricingOption($product2, 'lifetime', 10, BillingPeriod::LIFETIME));
        $productRepo->save($product2);
    }


    public function testSubscribe(): void
    {
        $user = new User(new Email('test@example.com'));

        // Basic subscription
        $subscription = $this->service->subscribe($user, 'Phpstorm', 'lifetime');
        $activeSubscriptions = $this->service->getActiveSubscriptions($user);

        $this->assertCount(1, $activeSubscriptions);
        $this->assertEquals($subscription->getId(), $activeSubscriptions[0]->getId());
        $this->assertNull($subscription->getEndDate());

        // Extends subscription
        $activeSubscriptions = $this->service->getActiveSubscriptions($user);
        $this->service->subscribe($user, 'Phpstorm', 'yearly');
        $this->assertCount(1, $activeSubscriptions);
        $this->assertEquals($subscription->getEndDate()->format('m-d'), new DateTimeImmutable()->modify('+1 year')->format('m-d'));

        // Add subscription
        $activeSubscriptions = $this->service->getActiveSubscriptions($user);
        $this->service->subscribe($user, 'Goland', 'yearly');
        $this->assertCount(2, $activeSubscriptions);
        $this->assertEquals($subscription->getEndDate()->format('m-d'), new DateTimeImmutable()->modify('+1 year')->format('m-d'));
    }

    public function testSubscribeProductNotFound(): void
    {
        $user = new User(new Email('test@example.com'));
        $this->expectException(ProductNotFoundException::class);;
        $this->service->subscribe($user, 'Webstorm', 'monthly');
    }

    public function testSubscribePriceNotFound(): void
    {
        $user = new User(new Email('test@example.com'));
        $this->expectException(PriceNotFoundException::class);;
        $this->service->subscribe($user, 'Phpstorm', 'weekly');
    }

    public function testCancelActiveSubscription(): void
    {
        $user = new User(new Email('test@example.com'));
        $this->service->subscribe($user, 'Phpstorm', 'lifetime');
        $activeSubscriptions = $this->service->getActiveSubscriptions($user);
        $this->assertCount(1, $activeSubscriptions);

        $this->service->cancelActiveSubscription($user, 'Phpstorm');

        $this->expectException(NoActiveSubscriptionException::class);
        $this->service->getActiveSubscriptions($user);
    }

    public function testCancelSubscriptionWithWrongProduct(): void
    {
        $user = new User(new Email('test@example.com'));
        $this->service->subscribe($user, 'Phpstorm', 'lifetime');
        $activeSubscriptions = $this->service->getActiveSubscriptions($user);
        $this->assertCount(1, $activeSubscriptions);

        $this->expectException(ProductNotFoundException::class);
        $this->service->cancelActiveSubscription($user, 'Golang');

        $this->service->getActiveSubscriptions($user);
    }
}
