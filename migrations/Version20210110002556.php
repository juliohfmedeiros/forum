<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110002556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adds OAuth2.0 default clients';
    }

    public function up(Schema $schema) : void
    {
        $client = [
            'id' => 'test_app',
            'name' => 'Test application client',
            'secret' => '738d15e84fd365d6711fe2a023485802',
            'redirect_uri' => serialize([])
        ];

        $this->addSql('INSERT INTO clients (id, name, secret, redirect_uri) values (:id, :name, :secret, :redirect_uri)', $client);
    }

    /**
     * @inheritDoc
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM clients WHERE id = :id', ['id' => 'test_app']);
    }


}
