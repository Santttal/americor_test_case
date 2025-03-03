<?php

declare(strict_types=1);

namespace App\Domain\IssuedCredit;

interface IssuedCreditRepositoryInterface
{
    public function save(IssuedCredit $issuedCredit): void;

    public function find(string $id): ?IssuedCredit;
}
