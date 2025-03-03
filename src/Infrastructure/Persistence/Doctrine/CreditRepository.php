<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Credit\Credit;
use App\Domain\Credit\CreditRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

final class CreditRepository extends ServiceEntityRepository implements CreditRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    public function save(Credit $credit): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($credit);
        $entityManager->flush();
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?Credit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }
}
