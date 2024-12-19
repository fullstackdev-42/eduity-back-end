<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625140446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE jobmap_organizations DROP CONSTRAINT fk_717173bfca508b63');
        $this->addSql('DROP INDEX uniq_717173bfca508b63');
        $this->addSql('ALTER TABLE jobmap_organizations ADD value_proposition TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD website_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD main_phone VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD main_email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD business_hours VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD date_founded DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations DROP security_organization_id');
        $this->addSql('ALTER TABLE security_resources DROP priority');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE security_resources ADD priority INT NOT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations ADD security_organization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organizations DROP value_proposition');
        $this->addSql('ALTER TABLE jobmap_organizations DROP website_url');
        $this->addSql('ALTER TABLE jobmap_organizations DROP main_phone');
        $this->addSql('ALTER TABLE jobmap_organizations DROP main_email');
        $this->addSql('ALTER TABLE jobmap_organizations DROP business_hours');
        $this->addSql('ALTER TABLE jobmap_organizations DROP date_founded');
        $this->addSql('ALTER TABLE jobmap_organizations ADD CONSTRAINT fk_717173bfca508b63 FOREIGN KEY (security_organization_id) REFERENCES security_organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_717173bfca508b63 ON jobmap_organizations (security_organization_id)');
    }
}
