<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250303121455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create clients, credits table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE clients (id VARCHAR(36) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, age INT NOT NULL, ssn VARCHAR(255) NOT NULL, credit_rating INT NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, monthly_income DOUBLE PRECISION NOT NULL, address_street VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(255) NOT NULL, address_zip VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE credits (id VARCHAR(36) NOT NULL, product_name VARCHAR(255) NOT NULL, term INT NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE credits');
    }
}
