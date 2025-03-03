<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Client\Client;
use App\Domain\Credit\Credit;

class CreditApprovalService
{
    public function canApprove(Client $client, Credit $credit): bool
    {
        $state = $client->getAddress()->state;
        if ('NY' === $state) {
            if (0 === random_int(0, 1)) {
                return false;
            }
        }

        if ($client->getCreditRating() <= 500) {
            return false;
        }
        if ($client->getMonthlyIncome() < 1000) {
            return false;
        }
        if ($client->getAge() < 18 || $client->getAge() > 60) {
            return false;
        }
        if (!in_array($state, ['CA', 'NY', 'NV'], true)) {
            return false;
        }

//        if ('CA' === $state) {
            $credit->increaseInterestRate(11.49); // todo  вынести в отдельный сервис
//        }

        return true;
    }
}
