<?php
declare(strict_types=1);

namespace App\Product\Domain\Service;

use App\Product\Application\Request\AddProductRequest;
use App\Product\Application\Request\PricingOptionData;
use App\Product\Domain\Enum\BillingPeriod;
use App\Product\Infrastructure\Persistence\InMemory\Infrastructure\InMemoryProductRepository;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    private ProductService $service;

    public function setUp(): void
    {
        $productRepo = new InMemoryProductRepository();

        $this->service = new ProductService($productRepo);
    }

    public function testAdd(): void
    {
        $price1 = new PricingOptionData('monthly', 10, BillingPeriod::MONTHLY);
        $price2 = new PricingOptionData('monthly', 10, BillingPeriod::MONTHLY);
        $price3 = new PricingOptionData('yearly', 10, BillingPeriod::YEARLY);
        $product = new AddProductRequest('Webstorm', 'IDE for Web', [$price1, $price2, $price3]);
        $this->service->add($product);
        $product = $this->service->findByName('Webstorm');
        $this->assertNotNull($product);
        $this->assertEquals('Webstorm', $product->getName());
        $this->assertEquals('IDE for Web', $product->getDescription());
        $this->assertCount(3, $product->getPricingOptions());
        $this->assertEquals('monthly', $product->getPricingOptions()[0]->getName());
    }
}