<?php

declare(strict_types=1);

namespace App\Application\Credit;

use App\Domain\Client\ClientRepositoryInterface;
use App\Domain\Credit\CreditRepositoryInterface;
use App\Domain\IssuedCredit\IssuedCredit;
use App\Domain\IssuedCredit\IssuedCreditRepositoryInterface;
use App\Domain\Service\CreditApprovalService;
use App\Domain\Service\CreditInterestRateAdjustmentService;
use App\Infrastructure\Notification\NotificationServiceInterface;
use Symfony\Component\Uid\Uuid;

readonly class IssueCreditHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreditRepositoryInterface $creditRepository,
        private IssuedCreditRepositoryInterface $issuedCreditRepository,
        private CreditApprovalService $approvalService,
        private CreditInterestRateAdjustmentService $creditInterestRateAdjustmentService,
        private NotificationServiceInterface $notificationService,
    ) {
    }

    public function handle(IssueCreditCommand $command): void
    {
        $client = $this->clientRepository->find($command->clientId);
        if (!$client) {
            throw new \Exception('Клиент не найден');
        }

        $credit = $this->creditRepository->find($command->creditId);
        if (!$credit) {
            throw new \Exception('Кредитный продукт не найден');
        }

        if (!$this->approvalService->canApprove($client, $credit)) {
            throw new \Exception('Кредит не может быть выдан клиенту');
        }

        $issuedCreditId = Uuid::v4()->toRfc4122();
        $issuedCredit = new IssuedCredit(
            $issuedCreditId,
            $client,
            $credit,
            $this->creditInterestRateAdjustmentService->adjust($client, $credit),
            $command->term,
            $command->amount,
            new \DateTimeImmutable(),
        );
        $this->issuedCreditRepository->save($issuedCredit);

        $message = sprintf('Кредит выдан для клиента %s', $client->getId());

        $this->notificationService->notify($client, $message);
    }
}
