<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503183518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hideout ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hideout ADD CONSTRAINT FK_2C2FE159F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_2C2FE159F92F3E70 ON hideout (country_id)');
        $this->addSql('ALTER TABLE mission DROP country_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hideout DROP FOREIGN KEY FK_2C2FE159F92F3E70');
        $this->addSql('DROP INDEX IDX_2C2FE159F92F3E70 ON hideout');
        $this->addSql('ALTER TABLE hideout DROP country_id');
        $this->addSql('ALTER TABLE mission ADD country_id INT DEFAULT NULL');
    }
}
