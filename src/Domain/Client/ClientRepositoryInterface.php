<?php

declare(strict_types=1);

namespace App\Domain\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;

    public function find(string $clientId): ?Client;
}
