<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002124917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_details (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_number VARCHAR(16) NOT NULL, expiration_date DATETIME NOT NULL, cryptogram INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, INDEX IDX_253C81FCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE selling (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, purchaser_id INT NOT NULL, card_detail_id INT NOT NULL, seller_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_5A491BAB700047D2 (ticket_id), INDEX IDX_5A491BABED255ED6 (purchaser_id), INDEX IDX_5A491BABACD8E0EF (card_detail_id), INDEX IDX_5A491BAB8DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, user_id_seller_id INT DEFAULT NULL, home_team VARCHAR(255) NOT NULL, away_team VARCHAR(255) NOT NULL, date_time DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, stadium VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA37E3C61F9 (owner_id), INDEX IDX_97A0ADA38D11E0FC (user_id_seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_details ADD CONSTRAINT FK_253C81FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABED255ED6 FOREIGN KEY (purchaser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABACD8E0EF FOREIGN KEY (card_detail_id) REFERENCES card_details (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38D11E0FC FOREIGN KEY (user_id_seller_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_details DROP FOREIGN KEY FK_253C81FCA76ED395');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB700047D2');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABED255ED6');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABACD8E0EF');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB8DE820D9');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37E3C61F9');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38D11E0FC');
        $this->addSql('DROP TABLE card_details');
        $this->addSql('DROP TABLE selling');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
