<?php

declare(strict_types=1);

namespace App\Restaurant\Application\Controller;

use App\Restaurant\Domain\Service\RestaurantService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController
{
    public function __construct(private readonly RestaurantService $restaurantService)
    {
    }

    #[Route('/restaurant', name: 'restaurant', methods: ['GET'])]
    public function helloWorld(): Response
    {
        return new Response(
            '<html>
                        <body>
                            Hello world! : ' . $this->restaurantService->menuServiceFunction() . ' 
                        </body>
                    </html>'
        );
    }
}
