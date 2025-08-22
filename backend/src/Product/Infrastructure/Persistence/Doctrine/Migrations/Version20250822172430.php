<?php

declare(strict_types=1);

namespace ProductMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250822172430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pricing_options (name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, billing_period VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, product_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_11CE746D4584665A ON pricing_options (product_id)');
        $this->addSql("ALTER TABLE pricing_options ADD CONSTRAINT chk_billing_period_valid CHECK (billing_period IN ('monthly', 'yearly', 'weekly', 'lifetime'))");
        $this->addSql('CREATE TABLE products (name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE pricing_options ADD CONSTRAINT FK_11CE746D4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pricing_options DROP CONSTRAINT FK_11CE746D4584665A');
        $this->addSql('DROP TABLE pricing_options');
        $this->addSql('DROP TABLE products');
    }
}
