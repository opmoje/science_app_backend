<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128201122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE belbin_coordinator belbin_coordinator SMALLINT DEFAULT NULL, CHANGE belbin_shaper belbin_shaper SMALLINT DEFAULT NULL, CHANGE belbin_team_worker belbin_team_worker SMALLINT DEFAULT NULL, CHANGE belbin_resource_investigator belbin_resource_investigator SMALLINT DEFAULT NULL, CHANGE belbin_plant belbin_plant SMALLINT DEFAULT NULL, CHANGE belbin_monitor_evaluator belbin_monitor_evaluator SMALLINT DEFAULT NULL, CHANGE belbin_implementer belbin_implementer SMALLINT DEFAULT NULL, CHANGE belbin_specialist belbin_specialist SMALLINT DEFAULT NULL, CHANGE belbin_completer_finisher belbin_completer_finisher SMALLINT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE belbin_coordinator belbin_coordinator SMALLINT NOT NULL, CHANGE belbin_shaper belbin_shaper SMALLINT NOT NULL, CHANGE belbin_team_worker belbin_team_worker SMALLINT NOT NULL, CHANGE belbin_resource_investigator belbin_resource_investigator SMALLINT NOT NULL, CHANGE belbin_plant belbin_plant SMALLINT NOT NULL, CHANGE belbin_monitor_evaluator belbin_monitor_evaluator SMALLINT NOT NULL, CHANGE belbin_implementer belbin_implementer SMALLINT NOT NULL, CHANGE belbin_specialist belbin_specialist SMALLINT NOT NULL, CHANGE belbin_completer_finisher belbin_completer_finisher SMALLINT NOT NULL');
    }
}
