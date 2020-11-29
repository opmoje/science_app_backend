<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128201533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scientific_job ADD aggregation_type VARCHAR(255) DEFAULT NULL, ADD cited_count INT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE INDEX IDX_43C9246E5C1CAD31 ON scientific_job (aggregation_type)');
        $this->addSql('CREATE INDEX IDX_43C9246E7BDD33C2 ON scientific_job (cited_count)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_43C9246E5C1CAD31 ON scientific_job');
        $this->addSql('DROP INDEX IDX_43C9246E7BDD33C2 ON scientific_job');
        $this->addSql('ALTER TABLE scientific_job DROP aggregation_type, DROP cited_count');
    }
}
