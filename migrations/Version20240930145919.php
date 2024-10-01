<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930145919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling ADD user_id_seller_id INT NOT NULL');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB8D11E0FC FOREIGN KEY (user_id_seller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A491BAB8D11E0FC ON selling (user_id_seller_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB8D11E0FC');
        $this->addSql('DROP INDEX IDX_5A491BAB8D11E0FC ON selling');
        $this->addSql('ALTER TABLE selling DROP user_id_seller_id');
    }
}
