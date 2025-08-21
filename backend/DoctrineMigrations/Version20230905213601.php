<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905213601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table user from symfony security';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
       CREATE TABLE "user" (
            id uuid DEFAULT gen_random_uuid() NOT NULL,
            email VARCHAR(180) UNIQUE NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR NOT NULL,
            PRIMARY KEY (id)
        );
');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('drop table "user";');
    }
}
