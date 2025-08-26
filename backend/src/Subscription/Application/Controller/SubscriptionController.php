<?php

declare(strict_types=1);

namespace App\Subscription\Application\Controller;

use App\Subscription\Application\Request\CancelRequest;
use App\Subscription\Application\Request\SubscribeRequest;
use App\Subscription\Domain\Model\Subscription;
use App\Subscription\Domain\Service\SubscriptionService;
use App\User\Domain\Model\User;
use DomainException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final readonly class SubscriptionController
{
    public function __construct(
        private SubscriptionService $subscriptionService,
        private Security $security,
    ) {
    }

    #[Route('/subscribe', name: 'api_subscription_subscribe', methods: [Request::METHOD_POST])]
    public function subscribe(
        #[MapRequestPayload] SubscribeRequest $request,
    ): Response {
        /** @var User $user */
        $user = $this->security->getUser();
        try {
            $subscription = $this->subscriptionService->subscribe(
                $user,
                $request->productName,
                $request->pricingOptionName,
            );

            return new JsonResponse([
                'message' => 'Subscription created',
                'subscription' => [
                    'start_date' => $subscription->getStartDate()->format('Y-m-d'),
                    'end_date' => $subscription->getEndDate()?->format('Y-m-d'),
                    'product' => $subscription->getProduct()->getName(),
                    'cancelled' => $subscription->isCancelled(),
                ],
            ]);
        } catch (DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/subscribe', name: 'api_subscription_get_active', methods: [Request::METHOD_GET])]
    public function getActiveSubscription(): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        try {
            $activeSubscription = $this->subscriptionService->getActiveSubscriptions($user);
        } catch (DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            array_map(fn(Subscription $subscription) => [
                'start_date' => $subscription->getStartDate()->format('Y-m-d'),
                'end_date' => $subscription->getEndDate()?->format('Y-m-d'),
                'product' => $subscription->getProduct()->getName(),
                'cancelled' => $subscription->isCancelled(),
            ], $activeSubscription),
        );
    }

    #[Route('/cancel', name: 'api_subscription_cancel', methods: [Request::METHOD_POST])]
    public function cancelSubscription(
        #[MapRequestPayload] CancelRequest $request,
    ): Response {
        /** @var User $user */
        $user = $this->security->getUser();

        try {
            $subscription = $this->subscriptionService->cancelActiveSubscription($user, $request->productName);
        } catch (DomainException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'message' => 'Subscription cancelled',
            'subscriptions' => [
                'start_date' => $subscription->getStartDate()->format('Y-m-d'),
                'end_date' => $subscription->getEndDate()?->format('Y-m-d'),
                'product' => $subscription->getProduct()->getName(),
                'cancelled' => $subscription->isCancelled(),
            ],
        ]);
    }
}
