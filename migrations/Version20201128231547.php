<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128231547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scientific_project DROP FOREIGN KEY FK_B75D48A4F4A44BFA');
        $this->addSql('DROP TABLE science');
        $this->addSql('DROP INDEX IDX_B75D48A4F4A44BFA ON scientific_project');
        $this->addSql('ALTER TABLE scientific_project ADD description TEXT NOT NULL, ADD participants_count_needed INT DEFAULT 2 NOT NULL, DROP science_id, CHANGE type type VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE science (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_671731A85E237E06 (name), INDEX IDX_671731A877153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE scientific_project ADD science_id INT UNSIGNED DEFAULT NULL, DROP description, DROP participants_count_needed, CHANGE type type VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE scientific_project ADD CONSTRAINT FK_B75D48A4F4A44BFA FOREIGN KEY (science_id) REFERENCES science (id)');
        $this->addSql('CREATE INDEX IDX_B75D48A4F4A44BFA ON scientific_project (science_id)');
    }
}
