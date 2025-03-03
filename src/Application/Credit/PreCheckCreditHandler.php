<?php
declare(strict_types=1);

namespace App\Application\Credit;

use App\Domain\Client\ClientRepositoryInterface;
use App\Domain\Credit\CreditRepositoryInterface;
use App\Domain\Service\CreditApprovalService;
use Exception;

readonly class PreCheckCreditHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreditRepositoryInterface $creditRepository,
        private CreditApprovalService $approvalService
    ) {}

    public function handle(PreCheckCreditCommand $command): bool
    {
        $client = $this->clientRepository->find($command->clientId);
        if (!$client) {
            throw new Exception('Клиент не найден');
        }
        $creditProduct = $this->creditRepository->find($command->creditProductId);
        if (!$creditProduct) {
            throw new Exception('Кредитный продукт не найден');
        }

        return $this->approvalService->canApprove($client, $creditProduct);
    }
}
