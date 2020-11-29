<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128200452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE scientific_job_user');
        $this->addSql('ALTER TABLE scientific_job ADD author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE scientific_job ADD CONSTRAINT FK_43C9246EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_43C9246EF675F31B ON scientific_job (author_id)');
        $this->addSql('DROP INDEX IDX_8D93D649A9D1C132 ON user');
        $this->addSql('DROP INDEX IDX_8D93D64959107AF8 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649C808BA5A ON user');
        $this->addSql('ALTER TABLE user ADD display_name VARCHAR(100) NOT NULL, DROP first_name, DROP middle_name, DROP last_name');
        $this->addSql('CREATE INDEX IDX_8D93D649D5499347 ON user (display_name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scientific_job_user (scientific_job_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_9CCEE61E3758B8EB (scientific_job_id), INDEX IDX_9CCEE61EA76ED395 (user_id), PRIMARY KEY(scientific_job_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE scientific_job_user ADD CONSTRAINT FK_9CCEE61E3758B8EB FOREIGN KEY (scientific_job_id) REFERENCES scientific_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scientific_job_user ADD CONSTRAINT FK_9CCEE61EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scientific_job DROP FOREIGN KEY FK_43C9246EF675F31B');
        $this->addSql('DROP INDEX IDX_43C9246EF675F31B ON scientific_job');
        $this->addSql('ALTER TABLE scientific_job DROP author_id');
        $this->addSql('DROP INDEX IDX_8D93D649D5499347 ON user');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD middle_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP display_name');
        $this->addSql('CREATE INDEX IDX_8D93D649A9D1C132 ON user (first_name)');
        $this->addSql('CREATE INDEX IDX_8D93D64959107AF8 ON user (middle_name)');
        $this->addSql('CREATE INDEX IDX_8D93D649C808BA5A ON user (last_name)');
    }
}
