<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Client\Client;

interface NotificationServiceInterface
{
    public function notify(Client $client, string $message): void;
}
