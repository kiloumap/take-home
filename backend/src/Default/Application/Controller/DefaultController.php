<?php

declare(strict_types=1);

namespace App\Default\Application\Controller;

use App\Default\Domain\Service\DefaultService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    public function __construct(private readonly DefaultService $defaultService)
    {
    }

    #[Route('/', name: 'default', methods: ['GET'])]
    public function helloWorld(): Response
    {
        return new Response(
            '<html>
                        <body>
                            Hello world! : ' . $this->defaultService->defaultServiceFunction() . ' 
                        </body>
                    </html>'
        );
    }
}
