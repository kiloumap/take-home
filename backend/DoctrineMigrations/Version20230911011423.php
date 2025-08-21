<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911011423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant (id UUID NOT NULL, owner_id UUID DEFAULT NULL, name VARCHAR(100) NOT NULL, address_line1 VARCHAR(100) NOT NULL, address_line2 VARCHAR(100) DEFAULT NULL, address_line3 VARCHAR(100) DEFAULT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, state VARCHAR(100) DEFAULT NULL, country VARCHAR(100) NOT NULL, phone VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, pickup BOOLEAN DEFAULT false NOT NULL, delivery BOOLEAN DEFAULT false NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EB95123F7E3C61F9 ON restaurant (owner_id)');
        $this->addSql('COMMENT ON COLUMN restaurant.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN restaurant.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE restaurant DROP CONSTRAINT FK_EB95123F7E3C61F9');
        $this->addSql('DROP TABLE restaurant');
    }
}
