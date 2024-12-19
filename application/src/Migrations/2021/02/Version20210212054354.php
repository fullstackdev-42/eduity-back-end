<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212054354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Populates the ACL permissions';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $randomNodeProvider = new RandomNodeProvider();

        $operations = [
            'View'      => 'read', 
            'Update'    => 'edit', 
            'Create'    => 'create', 
            'Delete'    => 'delete', 
            'Grant'     => 'grant', 
            'Share'     => 'share', 
            'Feedback'  => 'feedback',
            'Invite'    => 'invite',
        ];

        $date = (new \DateTime())->format('Y-m-d H:i:s');
        foreach ($operations as $name => $op) {
            $uuid = Uuid::uuid6($randomNodeProvider->getNode());
            $params =  [
                'uuid' => $uuid, 
                'name' => $name, 
                'operation' => $op,
                'created_by' => 'Eduity', 
                'updated_by' => 'Eduity', 
                'created_at' => $date, 
                'updated_at' => $date
            ];
            
            $this->addSql('INSERT INTO security_permissions (uuid, name, operation, created_by, updated_by, created_at, updated_at) VALUES (:uuid, :name, :operation, :created_by, :updated_by, :created_at, :updated_at)', $params);
        }

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
