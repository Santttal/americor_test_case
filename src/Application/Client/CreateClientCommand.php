<?php

declare(strict_types=1);

namespace App\Application\Client;

use App\Domain\Client\Address;

readonly class CreateClientCommand
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public int $age,
        public string $ssn,
        public Address $address,
        public int $creditRating,
        public string $email,
        public string $phone,
        public float $monthlyIncome,
    ) {
    }
}
