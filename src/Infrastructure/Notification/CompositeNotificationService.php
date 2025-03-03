<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Client\Client;

final readonly class CompositeNotificationService implements NotificationServiceInterface
{
    /**
     * @param NotificationServiceInterface[] $services
     */
    public function __construct(private array $services)
    {
    }

    public function notify(Client $client, string $message): void
    {
        foreach ($this->services as $service) {
            $service->notify($client, $message);
        }
    }
}
