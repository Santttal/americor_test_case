<?php
declare(strict_types=1);

namespace App\Application\Credit;

use App\Domain\Client\ClientRepositoryInterface;
use App\Domain\Credit\CreditRepositoryInterface;
use App\Domain\IssuedCredit\IssuedCredit;
use App\Domain\IssuedCredit\IssuedCreditRepositoryInterface;
use App\Domain\Service\CreditApprovalService;
use App\Infrastructure\Notification\NotificationServiceInterface;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Uid\Uuid;

readonly class IssueCreditHandler
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private CreditRepositoryInterface $creditRepository,
        private IssuedCreditRepositoryInterface $issuedCreditRepository,
        private CreditApprovalService $approvalService,
        private NotificationServiceInterface $notificationService
    ) {}

    public function handle(IssueCreditCommand $command): void
    {
        $client = $this->clientRepository->find($command->clientId);
        if (!$client) {
            throw new Exception('Клиент не найден');
        }

        $creditProduct = $this->creditRepository->find($command->creditProductId);
        if (!$creditProduct) {
            throw new Exception('Кредитный продукт не найден');
        }

        if (!$this->approvalService->canApprove($client, $creditProduct)) {
            throw new Exception('Кредит не может быть выдан клиенту');
        }

        $issuedCreditId = Uuid::v4()->toRfc4122();
        $issuedCredit = new IssuedCredit(
            $issuedCreditId,
            $client,
            $creditProduct,
            new DateTimeImmutable(),
        );
        $this->issuedCreditRepository->save($issuedCredit);

        $message = sprintf('Кредит выдан для клиента %s', $client->getId());

        $this->notificationService->notify($client, $message);
    }
}
