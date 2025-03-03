<?php

declare(strict_types=1);

namespace App\Domain\Credit;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'credits')]
class Credit
{
    public function __construct(#[ORM\Id]
        #[ORM\Column(type: 'string', length: 36)]
        private string $id, #[ORM\Column(type: 'string')]
        private string $productName, #[ORM\Column(type: 'integer')]
        private int $term, #[ORM\Column(type: 'float')]
        private float $interestRate, #[ORM\Column(type: 'float')]
        private float $amount)
    {
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
