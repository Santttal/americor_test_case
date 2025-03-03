<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Application\Credit\IssueCreditCommand;
use App\Application\Credit\IssueCreditHandler;
use App\Application\Credit\PreCheckCreditCommand;
use App\Application\Credit\PreCheckCreditHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CreditController extends AbstractController
{
    #[Route('/credit/pre-check', name: 'credit_pre_check', methods: ['POST'])]
    public function preCheck(Request $request, PreCheckCreditHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new PreCheckCreditCommand(
            $data['clientId'],
            $data['creditProductId']
        );

        try {
            $canIssue = $handler->handle($command);

            return new JsonResponse(['canIssue' => $canIssue]);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/credit/issue', name: 'credit_issue', methods: ['POST'])]
    public function issueCredit(Request $request, IssueCreditHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new IssueCreditCommand(
            $data['clientId'],
            $data['creditId'],
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
