<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001141447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_details CHANGE card_number card_number VARCHAR(16) NOT NULL, CHANGE cryptogram cryptogram INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE state state VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_email TO UNIQ_IDENTIFIER_EMAIL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_details CHANGE card_number card_number INT NOT NULL, CHANGE cryptogram cryptogram INT NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_identifier_email TO UNIQ_EMAIL');
        $this->addSql('ALTER TABLE ticket CHANGE state state VARCHAR(255) DEFAULT \'En vente\'');
    }
}
