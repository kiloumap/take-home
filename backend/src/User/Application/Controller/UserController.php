<?php
declare(strict_types=1);

namespace App\User\Application\Controller;

use App\User\Application\Request\LoginUserRequest;
use App\User\Application\Request\RegisterUserRequest;
use App\User\Domain\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

final readonly class UserController
{
    public function __construct(
        private UserService $userService,
        private Security $security,
        private JWTTokenManagerInterface $jwtManager
    ) {}

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] RegisterUserRequest $request
    ): JsonResponse {
        $user = $this->userService->register($request);

        $token = $this->jwtManager->create($user);

        return new JsonResponse([
            'user' => [
                'id' => $user->getId()->toString(),
                'email' => $user->getUserIdentifier(),
                'roles' => $user->getRoles()
            ],
            'token' => $token
        ]);
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        throw new \Exception('This should never be reached');
    }

    #[Route('/api/profile', name: 'api_profile', methods: ['GET'])]
    public function profile(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Not authenticated'], 401);
        }

        return new JsonResponse([
            'id' => $user->getId()->toString(),
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }
}