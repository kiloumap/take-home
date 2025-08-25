<?php

declare(strict_types=1);

namespace App\Product\Domain\Service;

use App\Product\Application\Request\AddProductRequest;
use App\Product\Domain\Model\PricingOption;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Validator\Constraints\Collection;

class ProductService
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }
    public function add(AddProductRequest $request): Product
    {
        $product = new Product(
            $request->name,
            $request->description,
        );

        foreach ($request->pricingOption as $pricingOption) {
            $pricingOption = new PricingOption(
                $product,
                $pricingOption->name,
                $pricingOption->price,
                $pricingOption->billingPeriod
            );
            $product->addPricingOption($pricingOption);
        }

        $this->productRepository->save($product);

        return $product;
    }
}
