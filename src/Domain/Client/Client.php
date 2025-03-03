<?php

declare(strict_types=1);

namespace App\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'clients')]
class Client
{
    public function __construct(#[ORM\Id]
        #[ORM\Column(type: 'string')]
        private string $id, #[ORM\Column(type: 'string')]
        private string $firstName, #[ORM\Column(type: 'string')]
        private string $lastName, #[ORM\Column(type: 'integer')]
        private int $age, #[ORM\Column(type: 'string')]
        private string $ssn, #[ORM\Embedded(class: Address::class)]
        private Address $address, #[ORM\Column(type: 'integer')]
        private int $creditRating, #[ORM\Column(type: 'string')]
        private string $email, #[ORM\Column(type: 'string')]
        private string $phone, #[ORM\Column(type: 'float')]
        private float $monthlyIncome)
    {
    }

    public function updateInformation(
        string $firstName,
        string $lastName,
        int $age,
        string $ssn,
        Address $address,
        int $creditRating,
        string $email,
        string $phone,
        float $monthlyIncome,
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->ssn = $ssn;
        $this->address = $address;
        $this->creditRating = $creditRating;
        $this->email = $email;
        $this->phone = $phone;
        $this->monthlyIncome = $monthlyIncome;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getCreditRating(): int
    {
        return $this->creditRating;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getMonthlyIncome(): float
    {
        return $this->monthlyIncome;
    }
}
