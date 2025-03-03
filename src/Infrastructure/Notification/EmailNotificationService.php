<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Client\Client;

final class EmailNotificationService implements NotificationServiceInterface
{
    public function notify(Client $client, string $message): void
    {
        // Реальная реализация? использовать Symfony Mailer?
        echo sprintf("Отправка Email на %s: %s\n", $client->getEmail(), $message);
    }
}
