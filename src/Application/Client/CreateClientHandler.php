<?php

declare(strict_types=1);

namespace App\Application\Client;

use App\Domain\Client\Client;
use App\Domain\Client\ClientRepositoryInterface;

readonly class CreateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository,
    ) {
    }

    public function handle(CreateClientCommand $command): void
    {
        $client = new Client(
            $command->id,
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
