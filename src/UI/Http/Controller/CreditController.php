<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\Credit\IssueCreditCommand;
use App\Application\Credit\IssueCreditHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CreditController extends AbstractController
{
    #[Route('/credit/issue', name: 'credit_issue', methods: ['POST'])]
    public function issueCredit(Request $request, IssueCreditHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new IssueCreditCommand(
            $data['clientId'],
            $data['creditId'],
            $data['productName'],
            (int) $data['term'],
            (float) $data['interestRate'],
            (float) $data['amount']
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
