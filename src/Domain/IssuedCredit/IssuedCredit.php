<?php

declare(strict_types=1);

namespace App\Domain\IssuedCredit;

use App\Domain\Client\Client;
use App\Domain\Credit\Credit;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'issued_credits')]
final class IssuedCredit
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', length: 36)]
        private string $id,
        #[ORM\ManyToOne(targetEntity: Client::class)]
        #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', nullable: false)]
        private Client $client,
        #[ORM\ManyToOne(targetEntity: Credit::class)]
        #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id', nullable: false)]
        private Credit $credit,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeInterface $issuedAt,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCredit(): Credit
    {
        return $this->credit;
    }

    public function getIssuedAt(): \DateTimeInterface
    {
        return $this->issuedAt;
    }
}
