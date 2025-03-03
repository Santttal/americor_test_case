<?php

declare(strict_types=1);

namespace App\Application\Client;

use App\Domain\Client\ClientRepositoryInterface;

readonly class UpdateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(UpdateClientCommand $command): void
    {
        $client = $this->repository->find($command->id);
        if (!$client) {
            throw new \Exception('Клиент не найден');
        }

        $client->updateInformation(
            $command->firstName,
            $command->lastName,
            $command->age,
            $command->ssn,
            $command->address,
            $command->creditRating,
            $command->email,
            $command->phone,
            $command->monthlyIncome,
        );

        $this->repository->save($client);
    }
}
