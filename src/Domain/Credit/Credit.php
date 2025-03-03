<?php

declare(strict_types=1);

namespace App\Domain\Credit;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'credits')]
class Credit
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $productName;

    #[ORM\Column(type: 'integer')]
    private int $term; // срок кредита в месяцах

    #[ORM\Column(type: 'float')]
    private float $interestRate;

    #[ORM\Column(type: 'float')]
    private float $amount;

    public function __construct(
        string $id,
        string $productName,
        int $term,
        float $interestRate,
        float $amount,
    ) {
        $this->id = $id;
        $this->productName = $productName;
        $this->term = $term;
        $this->interestRate = $interestRate;
        $this->amount = $amount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function increaseInterestRate(float $percentage): void
    {
        $this->interestRate += ($this->interestRate * $percentage / 100);
    }
}
