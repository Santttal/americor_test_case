<?php
declare(strict_types=1);

namespace App\Domain\IssuedCredit;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Client\Client;
use App\Domain\Credit\Credit;

#[ORM\Entity]
#[ORM\Table(name: 'issued_credits')]
final class IssuedCredit
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(name: "client_id", referencedColumnName: "id", nullable: false)]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: Credit::class)]
    #[ORM\JoinColumn(name: "credit_id", referencedColumnName: "id", nullable: false)]
    private Credit $credit;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $issuedAt;

    public function __construct(string $id, Client $client, Credit $credit, DateTimeInterface $issuedAt)
    {
        $this->id       = $id;
        $this->client   = $client;
        $this->credit   = $credit;
        $this->issuedAt = $issuedAt;
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

    public function getIssuedAt(): DateTimeInterface
    {
        return $this->issuedAt;
    }
}
