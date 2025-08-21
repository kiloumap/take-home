<?php

declare(strict_types=1);

namespace App\User\Application\Controller;

use App\User\Domain\Service\UserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

readonly class UserController
{
    public function __construct(private UserService $userService)
    {
    }

    #[Route('/user', name: 'user', methods: ['GET'])]
    public function helloWorld(): Response
    {
        return new Response(
            '<html lang="en">
                        <body>
                            Hello Menu! ' . $this->userService->userServiceFunction() . ' 
                        </body>
                    </html>'
        );
    }
}
