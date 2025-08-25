<?php
declare(strict_types=1);

namespace App\Subscription\Domain\Model;


use App\Product\Domain\Model\PricingOption;
use App\Product\Domain\Model\Product;
use App\User\Domain\Model\User;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class Subscription
{
    private Uuid $id;
    private bool $active = true;
    private bool $cancelled = false;
    private ?DateTimeImmutable $endDate;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt = null;
    private string $productName;

    public function __construct(
        private readonly DateTimeImmutable $startDate,
        private readonly User $user,
        private readonly PricingOption $pricingOption,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->productName = $pricingOption->getProduct()->getName();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getProduct(): Product
    {
        return $this->pricingOption->getProduct();
    }

    public function getUser(): User
    {
        return $this->user;
    }


    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): void
    {
        $this->cancelled = $cancelled;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }
    public function setEndDate(?DateTimeImmutable $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getPricingOption(): PricingOption
    {
        return $this->pricingOption;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductId(): Uuid
    {
        return $this->pricingOption->getProduct()->getId();
    }

    public function getCurrentPrice(): float
    {
        return $this->pricingOption->getPrice();
    }

    public function cancel(?string $reason = null): void
    {
        $this->cancelled = true;
        $this->active = false;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isCurrentlyActive(): bool
    {
        if (!$this->active || $this->cancelled) {
            return false;
        }

        $now = new DateTimeImmutable();

        if ($this->startDate > $now) {
            return false;
        }

        if ($this->endDate && $this->endDate < $now) {
            return false;
        }

        return true;
    }
}