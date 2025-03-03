<?php

declare(strict_types=1);

namespace App\Application\Credit;

readonly class IssueCreditCommand
{
    public function __construct(
        public string $clientId,
        public string $creditId,
        public string $productName,
        public int $term,
        public float $interestRate,
        public float $amount,
    ) {
    }
}
