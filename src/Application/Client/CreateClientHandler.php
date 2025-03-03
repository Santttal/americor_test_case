<?php

declare(strict_types=1);

namespace App\Application\Client;

use App\Domain\Client\Client;
use App\Domain\Client\ClientRepositoryInterface;
use Symfony\Component\Uid\Uuid;

readonly class CreateClientHandler
{
    public function __construct(
        private ClientRepositoryInterface $repository,
    ) {
    }

    public function handle(CreateClientCommand $command): void
    {
        $client = new Client(
            Uuid::v4()->toRfc4122(),
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
