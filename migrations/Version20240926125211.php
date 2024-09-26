<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926125211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_details (id INT AUTO_INCREMENT NOT NULL, card_number INT NOT NULL, expiration_date DATETIME NOT NULL, cryptogram INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE selling (id INT AUTO_INCREMENT NOT NULL, ticket_id_id INT NOT NULL, user_id_purchaser_id INT NOT NULL, card_detail_id_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_5A491BAB5774FDDC (ticket_id_id), INDEX IDX_5A491BABDC38472B (user_id_purchaser_id), INDEX IDX_5A491BAB1289FB0B (card_detail_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(50) NOT NULL, INDEX IDX_8D93D6494ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB5774FDDC FOREIGN KEY (ticket_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABDC38472B FOREIGN KEY (user_id_purchaser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB1289FB0B FOREIGN KEY (card_detail_id_id) REFERENCES card_details (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494ACC9A20 FOREIGN KEY (card_id) REFERENCES card_details (id)');
        $this->addSql('ALTER TABLE ticket ADD owner_id INT DEFAULT NULL, ADD user_id_seller_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38D11E0FC FOREIGN KEY (user_id_seller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA37E3C61F9 ON ticket (owner_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38D11E0FC ON ticket (user_id_seller_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37E3C61F9');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38D11E0FC');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB5774FDDC');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABDC38472B');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB1289FB0B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494ACC9A20');
        $this->addSql('DROP TABLE card_details');
        $this->addSql('DROP TABLE selling');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_97A0ADA37E3C61F9 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA38D11E0FC ON ticket');
        $this->addSql('ALTER TABLE ticket DROP owner_id, DROP user_id_seller_id');
    }
}
