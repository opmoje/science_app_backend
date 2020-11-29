<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128124627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scientific_project_user (scientific_project_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_C4516A4A954AD87F (scientific_project_id), INDEX IDX_C4516A4AA76ED395 (user_id), PRIMARY KEY(scientific_project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scientific_project_user ADD CONSTRAINT FK_C4516A4A954AD87F FOREIGN KEY (scientific_project_id) REFERENCES scientific_project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scientific_project_user ADD CONSTRAINT FK_C4516A4AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE scientific_project_user');
    }
}
