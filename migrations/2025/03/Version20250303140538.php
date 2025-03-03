<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250303140538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add issued_credits';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE issued_credits (id VARCHAR(36) NOT NULL, issued_at DATETIME NOT NULL, client_id VARCHAR(36) NOT NULL, credit_id VARCHAR(36) NOT NULL, INDEX IDX_4E9344A719EB6921 (client_id), INDEX IDX_4E9344A7CE062FF9 (credit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE issued_credits ADD CONSTRAINT FK_4E9344A719EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE issued_credits ADD CONSTRAINT FK_4E9344A7CE062FF9 FOREIGN KEY (credit_id) REFERENCES credits (id)');
        $this->addSql('ALTER TABLE clients CHANGE id id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE credits CHANGE id id VARCHAR(36) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE issued_credits DROP FOREIGN KEY FK_4E9344A719EB6921');
        $this->addSql('ALTER TABLE issued_credits DROP FOREIGN KEY FK_4E9344A7CE062FF9');
        $this->addSql('DROP TABLE issued_credits');
        $this->addSql('ALTER TABLE clients CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE credits CHANGE id id VARCHAR(255) NOT NULL');
    }
}
