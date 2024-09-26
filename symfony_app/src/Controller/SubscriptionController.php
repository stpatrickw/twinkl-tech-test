<?php

namespace App\Controller;

use App\Entity\User;
use App\Exceptions\UserSubscriptionException;
use App\Services\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class SubscriptionController extends AbstractController
{
    public function __construct(
        private SubscriptionService $subscriptionService,
        private SerializerInterface $serializer
    ) {}

    #[Route('/signup', name: 'subscription_signup', methods: ['POST'])]
    public function signup(Request $request): JsonResponse
    {
        try {
            $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
            $user->setLastUsedIP($request->getClientIp());
            $this->subscriptionService->signup($user);
        } catch (NotEncodableValueException|UserSubscriptionException $exception) {
            return new JsonResponse([
                'result' => false,
                'message' => $exception->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'result' => true
        ]);
    }
}
