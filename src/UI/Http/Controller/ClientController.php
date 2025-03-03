<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\Client\CreateClientCommand;
use App\Application\Client\CreateClientHandler;
use App\Application\Client\UpdateClientCommand;
use App\Application\Client\UpdateClientHandler;
use App\Domain\Client\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client/create', name: 'client_create', methods: ['POST'])]
    public function create(Request $request, CreateClientHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $address = new Address(
            $data['address']['street'],
            $data['address']['city'],
            $data['address']['state'],
            $data['address']['zip']
        );

        $command = new CreateClientCommand(
            $data['id'] ?? '', // либо генерировать идентификатор, либо проверять его наличие
            $data['firstName'],
            $data['lastName'],
            (int) $data['age'],
            $data['ssn'],
            $address,
            (int) $data['creditRating'],
            $data['email'],
            $data['phone'],
            (float) $data['monthlyIncome']
        );

        try {
            $handler->handle($command);

            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['status' => 'error', 'message' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }

    #[Route('/client/update', name: 'client_update', methods: ['PUT'])]
    public function update(Request $request, UpdateClientHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $address = new Address(
            $data['address']['street'],
            $data['address']['city'],
            $data['address']['state'],
            $data['address']['zip']
        );

        $command = new UpdateClientCommand(
            $data['id'], // идентификатор клиента, который нужно обновить
            $data['firstName'],
            $data['lastName'],
            (int) $data['age'],
            $data['ssn'],
            $address,
            (int) $data['creditRating'],
            $data['email'],
            $data['phone'],
            (float) $data['monthlyIncome']
        );

        try {
            $handler->handle($command);

            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['status' => 'error', 'message' => $e->getMessage()],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}
