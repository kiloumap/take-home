<?php
declare(strict_types=1);

namespace App\User\Application\Controller;

use App\User\Application\Request\RegisterUserRequest;
use App\User\Domain\Service\UserService;
use DomainException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

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
        try {
            $user = $this->userService->register($request);
        } catch (DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse([
            'message' => 'User created',
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
            return new JsonResponse(['error' => 'Not authenticated'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'id' => $user->getId()->toString(),
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }
}