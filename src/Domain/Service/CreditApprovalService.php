<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Client\Client;
use App\Domain\Credit\Credit;

class CreditApprovalService
{
    public function canApprove(Client $client, Credit $credit): bool
    {
        $address = $client->getAddress();

        if ($client->getCreditRating() <= 500) {
            return false;
        }
        if ($client->getMonthlyIncome() < 1000) {
            return false;
        }
        if ($client->getAge() < 18 || $client->getAge() > 60) {
            return false;
        }
        if (!in_array($address->state, ['CA', 'NY', 'NV'], true)) {
            return false;
        }

        return true;
    }

    /**
     * Принятие решения о выдаче кредита с учетом специфических правил:
     * - Для NY отказ производится случайным образом.
     * - Для CA процентная ставка увеличивается на 11.49%.
     */
    public function approve(Client $client, Credit $credit): bool
    {
        if (!$this->canApprove($client, $credit)) {
            return false;
        }

        $state = $client->getAddress()->state;
        if ('NY' === $state) {
            // случайное решение: примерно 50% отказ
            if (0 === random_int(0, 1)) {
                return false;
            }
        }

        if ('CA' === $state) {
            $credit->increaseInterestRate(11.49);
        }

        return true;
    }
}
