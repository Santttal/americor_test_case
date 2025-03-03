<?php

declare(strict_types=1);

namespace App\Application\Credit;

readonly class IssueCreditCommand
{
    public function __construct(
        public string $clientId,
        public string $creditId,
    ) {
    }
}
