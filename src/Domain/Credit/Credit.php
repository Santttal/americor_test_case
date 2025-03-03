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
        private string $id,
        #[ORM\Column(type: 'string')]
        private string $productName,
        #[ORM\Column(type: 'float')]
        private float $interestRate,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }
}
