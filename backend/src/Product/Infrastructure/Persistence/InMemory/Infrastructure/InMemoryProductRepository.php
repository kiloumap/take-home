<?php
declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\InMemory\Infrastructure;

use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    private array $products = [];

    public function save(Product $product): void
    {
        $this->products[$product->getName()] = $product;
    }

    public function findByName(string $name): ?Product
    {
        return $this->products[$name] ?? null;
    }
}