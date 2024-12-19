<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708143409 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE organization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE organization (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ext_log_entries ALTER object_class TYPE VARCHAR(191)');
        $this->addSql('ALTER TABLE ext_log_entries ALTER username TYPE VARCHAR(191)');
        $this->addSql('ALTER TABLE jobmap_organizations DROP CONSTRAINT fk_717173bf7e3c61f9');
        $this->addSql('DROP INDEX idx_717173bf7e3c61f9');
        $this->addSql('ALTER TABLE jobmap_organizations ADD entity_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD naics_major VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD naics_minor VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations DROP company_type');
        $this->addSql('ALTER TABLE jobmap_organizations DROP industry_sector');
        $this->addSql('ALTER TABLE jobmap_organizations DROP industry_subsector');
        $this->addSql('ALTER TABLE jobmap_organizations ALTER financial_year_ends TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE jobmap_organizations ALTER financial_year_ends DROP DEFAULT');
        $this->addSql('ALTER TABLE jobmap_organizations RENAME COLUMN owner_id TO administrator_id');
        $this->addSql('ALTER TABLE jobmap_organizations RENAME COLUMN full_time_per_week TO full_time_hours_per_week');
        $this->addSql('ALTER TABLE jobmap_organizations ADD CONSTRAINT FK_717173BF4B09E92C FOREIGN KEY (administrator_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_717173BF4B09E92C ON jobmap_organizations (administrator_id)');
        $this->addSql('ALTER TABLE security_resources ADD priority INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE organization_id_seq CASCADE');
        $this->addSql('DROP TABLE organization');
        $this->addSql('ALTER TABLE ext_log_entries ALTER object_class TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE ext_log_entries ALTER username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE security_resources DROP priority');
        $this->addSql('ALTER TABLE jobmap_organizations DROP CONSTRAINT FK_717173BF4B09E92C');
        $this->addSql('DROP INDEX IDX_717173BF4B09E92C');
        $this->addSql('ALTER TABLE jobmap_organizations ADD company_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD industry_sector VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD industry_subsector VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations DROP entity_type');
        $this->addSql('ALTER TABLE jobmap_organizations DROP naics_major');
        $this->addSql('ALTER TABLE jobmap_organizations DROP naics_minor');
        $this->addSql('ALTER TABLE jobmap_organizations ALTER financial_year_ends TYPE DATE');
        $this->addSql('ALTER TABLE jobmap_organizations ALTER financial_year_ends DROP DEFAULT');
        $this->addSql('ALTER TABLE jobmap_organizations ALTER financial_year_ends TYPE DATE');
        $this->addSql('ALTER TABLE jobmap_organizations RENAME COLUMN administrator_id TO owner_id');
        $this->addSql('ALTER TABLE jobmap_organizations RENAME COLUMN full_time_hours_per_week TO full_time_per_week');
        $this->addSql('ALTER TABLE jobmap_organizations ADD CONSTRAINT fk_717173bf7e3c61f9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_717173bf7e3c61f9 ON jobmap_organizations (owner_id)');
    }
}
