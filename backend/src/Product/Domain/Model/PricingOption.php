<?php
declare(strict_types=1);

namespace App\Product\Domain\Model;

use App\Product\Domain\Enum\BillingPeriod;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class PricingOption
{
    public Uuid $id;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct(
        private Product $product,
        private string $name,
        private float $price,
        private BillingPeriod $billingPeriod,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new DateTimeImmutable();
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
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getBillingPeriod(): string
    {
        return $this->billingPeriod->getDisplayName();
    }

    public function setBillingPeriod(BillingPeriod $billingPeriod): void
    {
        $this->billingPeriod = $billingPeriod;
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

    public function isMonthly(): bool
    {
        return $this->billingPeriod === BillingPeriod::MONTHLY;
    }

    public function isYearly(): bool
    {
        return $this->billingPeriod === BillingPeriod::YEARLY;
    }

    public function getDisplayName(): string
    {
        return sprintf('%s (%s)', $this->name, $this->billingPeriod->getLabel());
    }
}