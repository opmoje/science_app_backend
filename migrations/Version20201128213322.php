<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128213322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scientific_project ADD university_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE scientific_project ADD CONSTRAINT FK_B75D48A4309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_B75D48A4309D1878 ON scientific_project (university_id)');
        $this->addSql('ALTER TABLE user ADD university_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649309D1878 FOREIGN KEY (university_id) REFERENCES university (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649309D1878 ON user (university_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scientific_project DROP FOREIGN KEY FK_B75D48A4309D1878');
        $this->addSql('DROP INDEX IDX_B75D48A4309D1878 ON scientific_project');
        $this->addSql('ALTER TABLE scientific_project DROP university_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649309D1878');
        $this->addSql('DROP INDEX IDX_8D93D649309D1878 ON user');
        $this->addSql('ALTER TABLE user DROP university_id');
    }
}
