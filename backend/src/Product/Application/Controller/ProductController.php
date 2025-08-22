<?php

declare(strict_types=1);

namespace App\Product\Application\Controller;

use App\Product\Application\Request\AddProductRequest;
use App\Product\Domain\Model\PricingOption;
use App\Product\Domain\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ProductController
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    #[Route('/add', name: 'api_product_add', methods: ['POST'])]
    public function add(
        #[MapRequestPayload] AddProductRequest $request,
    ): Response {
        $product = $this->productService->add($request);

        return new JsonResponse([
            'product' => [
                'id' => $product->getId()->toString(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'pricingOptions' => [
                    array_map(fn(PricingOption $pricingOption) => [
                        'name' => $pricingOption->getName(),
                        'price' => $pricingOption->getPrice(),
                        'billingPeriod' => $pricingOption->getBillingPeriod(),
                    ], $product->getPricingOptions()->toArray())
                ],
            ],
        ]);
    }
}
