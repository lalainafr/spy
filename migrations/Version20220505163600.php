<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505163600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_268B9C9DF92F3E70 ON agent (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DF92F3E70');
        $this->addSql('DROP INDEX IDX_268B9C9DF92F3E70 ON agent');
        $this->addSql('ALTER TABLE agent DROP country_id');
    }
}
