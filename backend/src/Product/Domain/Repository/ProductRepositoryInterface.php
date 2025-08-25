<?php
declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Model\Product;
use App\Shared\Domain\ValueObject\ProductId;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;

    public function findByName(string $name): ?Product;
}