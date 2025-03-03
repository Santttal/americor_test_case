<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\IssuedCredit\IssuedCredit;
use App\Domain\IssuedCredit\IssuedCreditRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\LockMode;

/**
 * @extends ServiceEntityRepository<IssuedCredit>
 */
final class IssuedCreditRepository extends ServiceEntityRepository implements IssuedCreditRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IssuedCredit::class);
    }

    public function save(IssuedCredit $issuedCredit): void
    {
        $em = $this->getEntityManager();
        $em->persist($issuedCredit);
        $em->flush();
    }

    public function find(mixed $id, LockMode|int|null $lockMode = null, ?int $lockVersion = null): ?IssuedCredit
    {
        return parent::find($id, $lockMode, $lockVersion);
    }
}
