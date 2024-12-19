<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212054353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE uploaded_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ext_log_entries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE uploaded_files (id INT NOT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, size NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, avatar_image_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, is_locked BOOLEAN NOT NULL, lock_expiration_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, login_attempts INT NOT NULL, last_login_attempt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_email_confirmed BOOLEAN NOT NULL, email_confirmation_code VARCHAR(255) DEFAULT NULL, reset_password_code VARCHAR(255) DEFAULT NULL, unlock_code VARCHAR(255) DEFAULT NULL, reset_password_code_expiration_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9D17F50A6 ON users (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95C18B4B1 ON users (avatar_image_id)');
        $this->addSql('COMMENT ON COLUMN users.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_group (user_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(user_id, group_id))');
        $this->addSql('CREATE INDEX IDX_8F02BF9DA76ED395 ON user_group (user_id)');
        $this->addSql('CREATE INDEX IDX_8F02BF9DFE54D947 ON user_group (group_id)');
        $this->addSql('CREATE TABLE feedback_discussions (id SERIAL NOT NULL, rating_id INT DEFAULT NULL, approval_id INT DEFAULT NULL, subject_classname VARCHAR(255) NOT NULL, subject_id INT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93DEA7D17F50A6 ON feedback_discussions (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93DEA7A32EFC6 ON feedback_discussions (rating_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93DEA7FE65F000 ON feedback_discussions (approval_id)');
        $this->addSql('COMMENT ON COLUMN feedback_discussions.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_comment_ratings (id SERIAL NOT NULL, comment_id INT NOT NULL, user_id INT NOT NULL, score INT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_115DEBB5D17F50A6 ON feedback_comment_ratings (uuid)');
        $this->addSql('CREATE INDEX IDX_115DEBB5F8697D13 ON feedback_comment_ratings (comment_id)');
        $this->addSql('CREATE INDEX IDX_115DEBB5A76ED395 ON feedback_comment_ratings (user_id)');
        $this->addSql('COMMENT ON COLUMN feedback_comment_ratings.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_comment_threads (id SERIAL NOT NULL, discussion_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B065D1A1D17F50A6 ON feedback_comment_threads (uuid)');
        $this->addSql('CREATE INDEX IDX_B065D1A11ADED311 ON feedback_comment_threads (discussion_id)');
        $this->addSql('COMMENT ON COLUMN feedback_comment_threads.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_poll_ratings (id SERIAL NOT NULL, poll_option_id INT NOT NULL, user_id INT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AE616EEAD17F50A6 ON feedback_poll_ratings (uuid)');
        $this->addSql('CREATE INDEX IDX_AE616EEA6C13349B ON feedback_poll_ratings (poll_option_id)');
        $this->addSql('CREATE INDEX IDX_AE616EEAA76ED395 ON feedback_poll_ratings (user_id)');
        $this->addSql('COMMENT ON COLUMN feedback_poll_ratings.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_comments (id SERIAL NOT NULL, comment_thread_id INT NOT NULL, parent_id INT DEFAULT NULL, message TEXT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10D03D58D17F50A6 ON feedback_comments (uuid)');
        $this->addSql('CREATE INDEX IDX_10D03D58BEEA14F ON feedback_comments (comment_thread_id)');
        $this->addSql('CREATE INDEX IDX_10D03D58727ACA70 ON feedback_comments (parent_id)');
        $this->addSql('COMMENT ON COLUMN feedback_comments.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_polls (id SERIAL NOT NULL, discussion_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_899D5F8BD17F50A6 ON feedback_polls (uuid)');
        $this->addSql('CREATE INDEX IDX_899D5F8B1ADED311 ON feedback_polls (discussion_id)');
        $this->addSql('COMMENT ON COLUMN feedback_polls.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_approvals (id SERIAL NOT NULL, is_approved BOOLEAN NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9E08865D17F50A6 ON feedback_approvals (uuid)');
        $this->addSql('COMMENT ON COLUMN feedback_approvals.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_poll_options (id SERIAL NOT NULL, poll_id INT NOT NULL, value TEXT NOT NULL, description TEXT NOT NULL, "order" INT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0E293A4D17F50A6 ON feedback_poll_options (uuid)');
        $this->addSql('CREATE INDEX IDX_B0E293A43C947C0F ON feedback_poll_options (poll_id)');
        $this->addSql('COMMENT ON COLUMN feedback_poll_options.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE feedback_ratings (id SERIAL NOT NULL, score SMALLINT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FEF276AD17F50A6 ON feedback_ratings (uuid)');
        $this->addSql('COMMENT ON COLUMN feedback_ratings.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_notification (id SERIAL NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, data JSON NOT NULL, has_read BOOLEAN NOT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3F980AC8D17F50A6 ON user_notification (uuid)');
        $this->addSql('CREATE INDEX IDX_3F980AC8A76ED395 ON user_notification (user_id)');
        $this->addSql('COMMENT ON COLUMN user_notification.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_invitation (id SERIAL NOT NULL, user_id INT DEFAULT NULL, organization_id INT DEFAULT NULL, element_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, accept_code VARCHAR(255) NOT NULL, accepted BOOLEAN NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_567AA74ED17F50A6 ON user_invitation (uuid)');
        $this->addSql('CREATE INDEX IDX_567AA74EA76ED395 ON user_invitation (user_id)');
        $this->addSql('CREATE INDEX IDX_567AA74E32C8A3DE ON user_invitation (organization_id)');
        $this->addSql('CREATE INDEX IDX_567AA74E1F1F2A24 ON user_invitation (element_id)');
        $this->addSql('CREATE INDEX IDX_567AA74E7E3C61F9 ON user_invitation (owner_id)');
        $this->addSql('COMMENT ON COLUMN user_invitation.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE user_invitation_group (user_invitation_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(user_invitation_id, group_id))');
        $this->addSql('CREATE INDEX IDX_7C1E92394DD3D7A0 ON user_invitation_group (user_invitation_id)');
        $this->addSql('CREATE INDEX IDX_7C1E9239FE54D947 ON user_invitation_group (group_id)');
        $this->addSql('CREATE TABLE user_location (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, uuid UUID NOT NULL, is_primary BOOLEAN NOT NULL, street_address1 VARCHAR(255) DEFAULT NULL, street_address2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, country CHAR(2) DEFAULT NULL, zipcode VARCHAR(10) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(50) DEFAULT NULL, fax_number VARCHAR(50) DEFAULT NULL, latitude_and_longitude VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE136DCBD17F50A6 ON user_location (uuid)');
        $this->addSql('CREATE INDEX IDX_BE136DCBA76ED395 ON user_location (user_id)');
        $this->addSql('COMMENT ON COLUMN user_location.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE security_permissions (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, contexts JSON DEFAULT NULL, class VARCHAR(255) DEFAULT NULL, field VARCHAR(255) DEFAULT NULL, operation VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D429B0E5E237E06 ON security_permissions (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D429B0E1981A66D ON security_permissions (operation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D429B0ED17F50A6 ON security_permissions (uuid)');
        $this->addSql('CREATE INDEX idx_permission_operation ON security_permissions (operation)');
        $this->addSql('CREATE INDEX idx_permission_class ON security_permissions (class)');
        $this->addSql('CREATE INDEX idx_permission_field ON security_permissions (field)');
        $this->addSql('CREATE UNIQUE INDEX uniq_permission ON security_permissions (operation, class, field)');
        $this->addSql('COMMENT ON COLUMN security_permissions.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE security_resources (id SERIAL NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, subject_class VARCHAR(255) NOT NULL, subject_id INT NOT NULL, identity_class VARCHAR(255) NOT NULL, identity_id INT NOT NULL, allowance BOOLEAN DEFAULT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87D833D1D17F50A6 ON security_resources (uuid)');
        $this->addSql('CREATE INDEX idx_security_resources_subject_class ON security_resources (subject_class)');
        $this->addSql('CREATE INDEX idx_security_resources_subject_id ON security_resources (subject_id)');
        $this->addSql('CREATE INDEX idx_security_resources_identity_class ON security_resources (identity_class)');
        $this->addSql('CREATE INDEX idx_security_resources_identity_id ON security_resources (identity_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_security_resources ON security_resources (subject_class, subject_id, identity_class, identity_id)');
        $this->addSql('COMMENT ON COLUMN security_resources.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE security_permissions_associations (security_resource_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(security_resource_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_4F0BA724A99DCA44 ON security_permissions_associations (security_resource_id)');
        $this->addSql('CREATE INDEX IDX_4F0BA724FED90CCA ON security_permissions_associations (permission_id)');
        $this->addSql('CREATE TABLE security_groups (id SERIAL NOT NULL, organization_id INT NOT NULL, name VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C682CF65D17F50A6 ON security_groups (uuid)');
        $this->addSql('CREATE INDEX IDX_C682CF6532C8A3DE ON security_groups (organization_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_group_organization_name ON security_groups (organization_id, name)');
        $this->addSql('COMMENT ON COLUMN security_groups.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE security_organization (id SERIAL NOT NULL, organization_id INT NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB7B9DE5D17F50A6 ON security_organization (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FB7B9DE532C8A3DE ON security_organization (organization_id)');
        $this->addSql('COMMENT ON COLUMN security_organization.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE security_organization_user (security_organization_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(security_organization_id, user_id))');
        $this->addSql('CREATE INDEX IDX_D0446843CA508B63 ON security_organization_user (security_organization_id)');
        $this->addSql('CREATE INDEX IDX_D0446843A76ED395 ON security_organization_user (user_id)');
        $this->addSql('CREATE TABLE jobmap_organization_inventories (id SERIAL NOT NULL, organization_id INT NOT NULL, name VARCHAR(255) NOT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D878E202D17F50A6 ON jobmap_organization_inventories (uuid)');
        $this->addSql('CREATE INDEX IDX_D878E20232C8A3DE ON jobmap_organization_inventories (organization_id)');
        $this->addSql('COMMENT ON COLUMN jobmap_organization_inventories.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE jobmap_organizations (id SERIAL NOT NULL, owner_id INT NOT NULL, security_organization_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, company_type VARCHAR(255) DEFAULT NULL, mission_statement TEXT DEFAULT NULL, total_employees INT DEFAULT NULL, financial_year_ends DATE DEFAULT NULL, industry_sector VARCHAR(255) DEFAULT NULL, industry_subsector VARCHAR(255) DEFAULT NULL, annual_revenue NUMERIC(10, 2) DEFAULT NULL, full_time_per_week INT DEFAULT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717173BFD17F50A6 ON jobmap_organizations (uuid)');
        $this->addSql('CREATE INDEX IDX_717173BF7E3C61F9 ON jobmap_organizations (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717173BFCA508B63 ON jobmap_organizations (security_organization_id)');
        $this->addSql('COMMENT ON COLUMN jobmap_organizations.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE jobmap_organization_inventory_node_element_attributes (id SERIAL NOT NULL, element_id INT DEFAULT NULL, revision_id INT NOT NULL, name VARCHAR(255) NOT NULL, value JSON NOT NULL, originator_type VARCHAR(255) DEFAULT NULL, originator_id INT DEFAULT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8E8CC34D17F50A6 ON jobmap_organization_inventory_node_element_attributes (uuid)');
        $this->addSql('CREATE INDEX IDX_E8E8CC341F1F2A24 ON jobmap_organization_inventory_node_element_attributes (element_id)');
        $this->addSql('COMMENT ON COLUMN jobmap_organization_inventory_node_element_attributes.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE jobmap_organization_inventory_nodes (id SERIAL NOT NULL, inventory_id INT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, revision_id INT NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, lvl INT NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9976ABAD17F50A6 ON jobmap_organization_inventory_nodes (uuid)');
        $this->addSql('CREATE INDEX IDX_E9976ABA9EEA759 ON jobmap_organization_inventory_nodes (inventory_id)');
        $this->addSql('CREATE INDEX IDX_E9976ABAA977936C ON jobmap_organization_inventory_nodes (tree_root)');
        $this->addSql('CREATE INDEX IDX_E9976ABA727ACA70 ON jobmap_organization_inventory_nodes (parent_id)');
        $this->addSql('COMMENT ON COLUMN jobmap_organization_inventory_nodes.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE jobmap_organization_inventory_node_elements (id SERIAL NOT NULL, revision_id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, uuid UUID NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DD82C7BD17F50A6 ON jobmap_organization_inventory_node_elements (uuid)');
        $this->addSql('COMMENT ON COLUMN jobmap_organization_inventory_node_elements.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE jobmap_organization_locations (id SERIAL NOT NULL, organization_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, business_open_hours TIME(0) WITHOUT TIME ZONE DEFAULT NULL, business_close_hours TIME(0) WITHOUT TIME ZONE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, uuid UUID NOT NULL, is_primary BOOLEAN NOT NULL, street_address1 VARCHAR(255) DEFAULT NULL, street_address2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, country CHAR(2) DEFAULT NULL, zipcode VARCHAR(10) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(50) DEFAULT NULL, fax_number VARCHAR(50) DEFAULT NULL, latitude_and_longitude VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7DE43520D17F50A6 ON jobmap_organization_locations (uuid)');
        $this->addSql('CREATE INDEX IDX_7DE4352032C8A3DE ON jobmap_organization_locations (organization_id)');
        $this->addSql('COMMENT ON COLUMN jobmap_organization_locations.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ext_log_entries (id INT NOT NULL, action VARCHAR(8) NOT NULL, logged_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data TEXT DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX log_class_lookup_idx ON ext_log_entries (object_class)');
        $this->addSql('CREATE INDEX log_date_lookup_idx ON ext_log_entries (logged_at)');
        $this->addSql('CREATE INDEX log_user_lookup_idx ON ext_log_entries (username)');
        $this->addSql('CREATE INDEX log_version_lookup_idx ON ext_log_entries (object_id, object_class, version)');
        $this->addSql('COMMENT ON COLUMN ext_log_entries.data IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E95C18B4B1 FOREIGN KEY (avatar_image_id) REFERENCES uploaded_files (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DFE54D947 FOREIGN KEY (group_id) REFERENCES security_groups (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_discussions ADD CONSTRAINT FK_93DEA7A32EFC6 FOREIGN KEY (rating_id) REFERENCES feedback_ratings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_discussions ADD CONSTRAINT FK_93DEA7FE65F000 FOREIGN KEY (approval_id) REFERENCES feedback_approvals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_comment_ratings ADD CONSTRAINT FK_115DEBB5F8697D13 FOREIGN KEY (comment_id) REFERENCES feedback_comments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_comment_ratings ADD CONSTRAINT FK_115DEBB5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_comment_threads ADD CONSTRAINT FK_B065D1A11ADED311 FOREIGN KEY (discussion_id) REFERENCES feedback_discussions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_poll_ratings ADD CONSTRAINT FK_AE616EEA6C13349B FOREIGN KEY (poll_option_id) REFERENCES feedback_poll_options (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_poll_ratings ADD CONSTRAINT FK_AE616EEAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_comments ADD CONSTRAINT FK_10D03D58BEEA14F FOREIGN KEY (comment_thread_id) REFERENCES feedback_comment_threads (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_comments ADD CONSTRAINT FK_10D03D58727ACA70 FOREIGN KEY (parent_id) REFERENCES feedback_comments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_polls ADD CONSTRAINT FK_899D5F8B1ADED311 FOREIGN KEY (discussion_id) REFERENCES feedback_discussions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE feedback_poll_options ADD CONSTRAINT FK_B0E293A43C947C0F FOREIGN KEY (poll_id) REFERENCES feedback_polls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation ADD CONSTRAINT FK_567AA74EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation ADD CONSTRAINT FK_567AA74E32C8A3DE FOREIGN KEY (organization_id) REFERENCES jobmap_organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation ADD CONSTRAINT FK_567AA74E1F1F2A24 FOREIGN KEY (element_id) REFERENCES jobmap_organization_inventory_node_elements (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation ADD CONSTRAINT FK_567AA74E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation_group ADD CONSTRAINT FK_7C1E92394DD3D7A0 FOREIGN KEY (user_invitation_id) REFERENCES user_invitation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_invitation_group ADD CONSTRAINT FK_7C1E9239FE54D947 FOREIGN KEY (group_id) REFERENCES security_groups (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_location ADD CONSTRAINT FK_BE136DCBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_permissions_associations ADD CONSTRAINT FK_4F0BA724A99DCA44 FOREIGN KEY (security_resource_id) REFERENCES security_resources (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_permissions_associations ADD CONSTRAINT FK_4F0BA724FED90CCA FOREIGN KEY (permission_id) REFERENCES security_permissions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_groups ADD CONSTRAINT FK_C682CF6532C8A3DE FOREIGN KEY (organization_id) REFERENCES security_organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_organization ADD CONSTRAINT FK_FB7B9DE532C8A3DE FOREIGN KEY (organization_id) REFERENCES jobmap_organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_organization_user ADD CONSTRAINT FK_D0446843CA508B63 FOREIGN KEY (security_organization_id) REFERENCES security_organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE security_organization_user ADD CONSTRAINT FK_D0446843A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventories ADD CONSTRAINT FK_D878E20232C8A3DE FOREIGN KEY (organization_id) REFERENCES jobmap_organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organizations ADD CONSTRAINT FK_717173BF7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organizations ADD CONSTRAINT FK_717173BFCA508B63 FOREIGN KEY (security_organization_id) REFERENCES security_organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes ADD CONSTRAINT FK_E8E8CC341F1F2A24 FOREIGN KEY (element_id) REFERENCES jobmap_organization_inventory_node_elements (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes ADD CONSTRAINT FK_E9976ABA9EEA759 FOREIGN KEY (inventory_id) REFERENCES jobmap_organization_inventories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes ADD CONSTRAINT FK_E9976ABAA977936C FOREIGN KEY (tree_root) REFERENCES jobmap_organization_inventory_nodes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes ADD CONSTRAINT FK_E9976ABA727ACA70 FOREIGN KEY (parent_id) REFERENCES jobmap_organization_inventory_nodes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE jobmap_organization_locations ADD CONSTRAINT FK_7DE4352032C8A3DE FOREIGN KEY (organization_id) REFERENCES jobmap_organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E95C18B4B1');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT FK_8F02BF9DA76ED395');
        $this->addSql('ALTER TABLE feedback_comment_ratings DROP CONSTRAINT FK_115DEBB5A76ED395');
        $this->addSql('ALTER TABLE feedback_poll_ratings DROP CONSTRAINT FK_AE616EEAA76ED395');
        $this->addSql('ALTER TABLE user_notification DROP CONSTRAINT FK_3F980AC8A76ED395');
        $this->addSql('ALTER TABLE user_invitation DROP CONSTRAINT FK_567AA74EA76ED395');
        $this->addSql('ALTER TABLE user_invitation DROP CONSTRAINT FK_567AA74E7E3C61F9');
        $this->addSql('ALTER TABLE user_location DROP CONSTRAINT FK_BE136DCBA76ED395');
        $this->addSql('ALTER TABLE security_organization_user DROP CONSTRAINT FK_D0446843A76ED395');
        $this->addSql('ALTER TABLE jobmap_organizations DROP CONSTRAINT FK_717173BF7E3C61F9');
        $this->addSql('ALTER TABLE feedback_comment_threads DROP CONSTRAINT FK_B065D1A11ADED311');
        $this->addSql('ALTER TABLE feedback_polls DROP CONSTRAINT FK_899D5F8B1ADED311');
        $this->addSql('ALTER TABLE feedback_comments DROP CONSTRAINT FK_10D03D58BEEA14F');
        $this->addSql('ALTER TABLE feedback_comment_ratings DROP CONSTRAINT FK_115DEBB5F8697D13');
        $this->addSql('ALTER TABLE feedback_comments DROP CONSTRAINT FK_10D03D58727ACA70');
        $this->addSql('ALTER TABLE feedback_poll_options DROP CONSTRAINT FK_B0E293A43C947C0F');
        $this->addSql('ALTER TABLE feedback_discussions DROP CONSTRAINT FK_93DEA7FE65F000');
        $this->addSql('ALTER TABLE feedback_poll_ratings DROP CONSTRAINT FK_AE616EEA6C13349B');
        $this->addSql('ALTER TABLE feedback_discussions DROP CONSTRAINT FK_93DEA7A32EFC6');
        $this->addSql('ALTER TABLE user_invitation_group DROP CONSTRAINT FK_7C1E92394DD3D7A0');
        $this->addSql('ALTER TABLE security_permissions_associations DROP CONSTRAINT FK_4F0BA724FED90CCA');
        $this->addSql('ALTER TABLE security_permissions_associations DROP CONSTRAINT FK_4F0BA724A99DCA44');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT FK_8F02BF9DFE54D947');
        $this->addSql('ALTER TABLE user_invitation_group DROP CONSTRAINT FK_7C1E9239FE54D947');
        $this->addSql('ALTER TABLE security_groups DROP CONSTRAINT FK_C682CF6532C8A3DE');
        $this->addSql('ALTER TABLE security_organization_user DROP CONSTRAINT FK_D0446843CA508B63');
        $this->addSql('ALTER TABLE jobmap_organizations DROP CONSTRAINT FK_717173BFCA508B63');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes DROP CONSTRAINT FK_E9976ABA9EEA759');
        $this->addSql('ALTER TABLE user_invitation DROP CONSTRAINT FK_567AA74E32C8A3DE');
        $this->addSql('ALTER TABLE security_organization DROP CONSTRAINT FK_FB7B9DE532C8A3DE');
        $this->addSql('ALTER TABLE jobmap_organization_inventories DROP CONSTRAINT FK_D878E20232C8A3DE');
        $this->addSql('ALTER TABLE jobmap_organization_locations DROP CONSTRAINT FK_7DE4352032C8A3DE');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes DROP CONSTRAINT FK_E9976ABAA977936C');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_nodes DROP CONSTRAINT FK_E9976ABA727ACA70');
        $this->addSql('ALTER TABLE user_invitation DROP CONSTRAINT FK_567AA74E1F1F2A24');
        $this->addSql('ALTER TABLE jobmap_organization_inventory_node_element_attributes DROP CONSTRAINT FK_E8E8CC341F1F2A24');
        $this->addSql('DROP SEQUENCE uploaded_files_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ext_log_entries_id_seq CASCADE');
        $this->addSql('DROP TABLE uploaded_files');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE feedback_discussions');
        $this->addSql('DROP TABLE feedback_comment_ratings');
        $this->addSql('DROP TABLE feedback_comment_threads');
        $this->addSql('DROP TABLE feedback_poll_ratings');
        $this->addSql('DROP TABLE feedback_comments');
        $this->addSql('DROP TABLE feedback_polls');
        $this->addSql('DROP TABLE feedback_approvals');
        $this->addSql('DROP TABLE feedback_poll_options');
        $this->addSql('DROP TABLE feedback_ratings');
        $this->addSql('DROP TABLE user_notification');
        $this->addSql('DROP TABLE user_invitation');
        $this->addSql('DROP TABLE user_invitation_group');
        $this->addSql('DROP TABLE user_location');
        $this->addSql('DROP TABLE security_permissions');
        $this->addSql('DROP TABLE security_resources');
        $this->addSql('DROP TABLE security_permissions_associations');
        $this->addSql('DROP TABLE security_groups');
        $this->addSql('DROP TABLE security_organization');
        $this->addSql('DROP TABLE security_organization_user');
        $this->addSql('DROP TABLE jobmap_organization_inventories');
        $this->addSql('DROP TABLE jobmap_organizations');
        $this->addSql('DROP TABLE jobmap_organization_inventory_node_element_attributes');
        $this->addSql('DROP TABLE jobmap_organization_inventory_nodes');
        $this->addSql('DROP TABLE jobmap_organization_inventory_node_elements');
        $this->addSql('DROP TABLE jobmap_organization_locations');
        $this->addSql('DROP TABLE ext_log_entries');
    }
}
