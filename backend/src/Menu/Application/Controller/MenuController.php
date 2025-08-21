<?php

declare(strict_types=1);

namespace App\Menu\Application\Controller;

use App\Menu\Domain\Service\MenuService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController
{
    public function __construct(private readonly MenuService $menuService)
    {
    }

    #[Route('/menu', name: 'menu', methods: ['GET'])]
    public function helloWorld(): Response
    {
        return new Response(
            '<html>
                        <body>
                            Hello Menu! : ' . $this->menuService->menuServiceFunction() . ' 
                        </body>
                    </html>'
        );
    }
}
