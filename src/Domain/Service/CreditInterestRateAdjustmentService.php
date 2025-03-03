<?php

namespace App\Domain\Service;

use App\Domain\Client\Client;
use App\Domain\Credit\Credit;

readonly class CreditInterestRateAdjustmentService
{
    public function adjust(Client $client, Credit $credit): float
    {
        $state = $client->getAddress()->state;

        if ('CA' === $state) {
            return $credit->getInterestRate() + 11.49;
        }

        return $credit->getInterestRate();
    }
}
