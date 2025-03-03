<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303151958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'fix db structure';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credits DROP term, DROP amount');
        $this->addSql('ALTER TABLE issued_credits ADD interest_rate DOUBLE PRECISION NOT NULL, ADD term INT NOT NULL, ADD amount DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE issued_credits DROP interest_rate, DROP term, DROP amount');
        $this->addSql('ALTER TABLE credits ADD term INT NOT NULL, ADD amount DOUBLE PRECISION NOT NULL');
    }
}
