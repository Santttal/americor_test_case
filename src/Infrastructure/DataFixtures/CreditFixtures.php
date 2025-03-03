<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\Credit\Credit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class CreditFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $credit1 = new Credit(
            Uuid::v4()->toRfc4122(),
            'Test Credit 1',
            12,
            5.0,
            10000.0
        );

        $credit2 = new Credit(
            Uuid::v4()->toRfc4122(),
            'Test Credit 2',
            24,
            6.5,
            20000.0
        );

        $credit3 = new Credit(
            Uuid::v4()->toRfc4122(),
            'Test Credit 3',
            36,
            7.2,
            30000.0
        );

        $manager->persist($credit1);
        $manager->persist($credit2);
        $manager->persist($credit3);

        $manager->flush();
    }
}
