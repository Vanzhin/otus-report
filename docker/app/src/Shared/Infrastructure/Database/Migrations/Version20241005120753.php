<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005120753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reports_report_modifications (id VARCHAR(26) NOT NULL, report_id VARCHAR(26) DEFAULT NULL, status VARCHAR(26) NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7627C21F4BD2A4C0 ON reports_report_modifications (report_id)');
        $this->addSql('COMMENT ON COLUMN reports_report_modifications.changed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reports_report_modifications ADD CONSTRAINT FK_7627C21F4BD2A4C0 FOREIGN KEY (report_id) REFERENCES report_report (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report_report DROP status');
        $this->addSql('ALTER TABLE report_report DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reports_report_modifications DROP CONSTRAINT FK_7627C21F4BD2A4C0');
        $this->addSql('DROP TABLE reports_report_modifications');
        $this->addSql('ALTER TABLE report_report ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE report_report ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN report_report.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
