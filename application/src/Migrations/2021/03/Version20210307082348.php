<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307082348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes RENAME COLUMN value TO content');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ALTER originator_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ALTER originator_id DROP DEFAULT');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ADD node_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ALTER description DROP DEFAULT');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ADD CONSTRAINT FK_6DD82C7B460D9FD7 FOREIGN KEY (node_id) REFERENCES jobmap_organization_inventory_nodes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ADD CONSTRAINT FK_6DD82C7B727ACA70 FOREIGN KEY (parent_id) REFERENCES jobmap_organization_inventory_node_elements (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6DD82C7B460D9FD7 ON jobmap_organization_inventory_node_elements (node_id)');
        $this->addSql('CREATE INDEX IDX_6DD82C7B727ACA70 ON jobmap_organization_inventory_node_elements (parent_id)');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements DROP CONSTRAINT FK_6DD82C7B460D9FD7');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements DROP CONSTRAINT FK_6DD82C7B727ACA70');
        $this->addSql('DROP INDEX IDX_6DD82C7B460D9FD7');
        $this->addSql('DROP INDEX IDX_6DD82C7B727ACA70');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements DROP node_id');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements DROP parent_id');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_elements ALTER description DROP DEFAULT');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes RENAME COLUMN content TO value');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ALTER originator_id TYPE INT');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ALTER originator_id DROP DEFAULT');
    }
}
