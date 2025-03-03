<?php

declare(strict_types=1);

namespace App\Domain\Credit;

interface CreditRepositoryInterface
{
    public function save(Credit $credit): void;

    public function find(string $creditId): ?Credit;
}
