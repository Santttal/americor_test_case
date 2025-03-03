<?php

declare(strict_types=1);

namespace App\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: 'string')]
    public readonly string $street;

    #[ORM\Column(type: 'string')]
    public readonly string $city;

    #[ORM\Column(type: 'string')]
    public readonly string $state;

    #[ORM\Column(type: 'string')]
    public readonly string $zip;

    public function __construct(
        string $street,
        string $city,
        string $state,
        string $zip,
    ) {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }
}
