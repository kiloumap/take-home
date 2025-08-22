<?php
declare(strict_types=1);


namespace App\Product\Domain\Model;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class Product
{
    public Uuid $id;
    /** @var Collection<int, PricingOption> */
    private ?Collection $pricingOptions;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct(
        private string $name,
        private string $description,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new DateTimeImmutable();
        $this->pricingOptions = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPricingOptions(): Collection
    {
        return $this->pricingOptions;
    }

    public function setPricingOptions(Collection $pricingOptions): void
    {
        $this->pricingOptions = $pricingOptions;
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

    public function addPricingOption(PricingOption $pricingOption): void
    {
        if (!$this->pricingOptions->contains($pricingOption)) {
            $this->pricingOptions->add($pricingOption);
        }
    }
}