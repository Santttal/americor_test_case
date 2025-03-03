<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Client\Client;
use App\Domain\Client\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
final class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function save(Client $client): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($client);
        $entityManager->flush();
    }

    #[\Override]
    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Client
    {
        return parent::find($id);
    }
}
