<?php

declare(strict_types=1);

namespace App\Application\Credit;

use App\Domain\Client\ClientRepositoryInterface;
use App\Domain\Credit\Credit;
use App\Domain\Credit\CreditRepositoryInterface;
use App\Domain\Service\CreditApprovalService;
use App\Infrastructure\Notification\NotificationServiceInterface;

readonly class IssueCreditHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreditRepositoryInterface $creditRepository,
        private CreditApprovalService $approvalService,
        private NotificationServiceInterface $notificationService,
    ) {
    }

    public function handle(IssueCreditCommand $command): void
    {
        $client = $this->clientRepository->find($command->clientId);
        if (!$client) {
            throw new \Exception('Клиент не найден');
        }

        $credit = new Credit(
            $command->creditId,
            $command->productName,
            $command->term,
            $command->interestRate,
            $command->amount,
        );

        $approved = $this->approvalService->approve($client, $credit);

        if ($approved) {
            $this->creditRepository->save($credit);
            $message = sprintf('Кредит одобрен для клиента %s', $client->getId());
        } else {
            $message = sprintf('Кредит отказан для клиента %s', $client->getId());
        }

        $this->notificationService->notify($client, $message);
    }
}
