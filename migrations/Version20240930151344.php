<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930151344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB5774FDDC');
        $this->addSql('DROP INDEX IDX_5A491BAB5774FDDC ON selling');
        $this->addSql('ALTER TABLE selling CHANGE ticket_id_id ticket_id INT NOT NULL');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('CREATE INDEX IDX_5A491BAB700047D2 ON selling (ticket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB700047D2');
        $this->addSql('DROP INDEX IDX_5A491BAB700047D2 ON selling');
        $this->addSql('ALTER TABLE selling CHANGE ticket_id ticket_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB5774FDDC FOREIGN KEY (ticket_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5A491BAB5774FDDC ON selling (ticket_id_id)');
    }
}
