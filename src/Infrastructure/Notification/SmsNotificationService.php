<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Client\Client;

final class SmsNotificationService implements NotificationServiceInterface
{
    public function notify(Client $client, string $message): void
    {
        // Реальная реализация? интеграция с SMS-шлюзом?
        echo sprintf("Отправка SMS на %s: %s\n", $client->getPhone(), $message);
    }
}
