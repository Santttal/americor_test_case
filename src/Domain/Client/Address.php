<?php

declare(strict_types=1);

namespace App\Domain\Client;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    public function __construct(#[ORM\Column(type: 'string')]
        public readonly string $street, #[ORM\Column(type: 'string')]
        public readonly string $city, #[ORM\Column(type: 'string')]
        public readonly string $state, #[ORM\Column(type: 'string')]
        public readonly string $zip)
    {
    }
}
