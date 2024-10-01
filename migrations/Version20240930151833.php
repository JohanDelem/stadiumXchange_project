<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930151833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB1289FB0B');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB8D11E0FC');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABDC38472B');
        $this->addSql('DROP INDEX IDX_5A491BAB1289FB0B ON selling');
        $this->addSql('DROP INDEX IDX_5A491BAB8D11E0FC ON selling');
        $this->addSql('DROP INDEX IDX_5A491BABDC38472B ON selling');
        $this->addSql('ALTER TABLE selling ADD purchaser_id INT NOT NULL, ADD card_detail_id INT NOT NULL, ADD seller_id INT NOT NULL, DROP user_id_purchaser_id, DROP card_detail_id_id, DROP user_id_seller_id');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABED255ED6 FOREIGN KEY (purchaser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABACD8E0EF FOREIGN KEY (card_detail_id) REFERENCES card_details (id)');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A491BABED255ED6 ON selling (purchaser_id)');
        $this->addSql('CREATE INDEX IDX_5A491BABACD8E0EF ON selling (card_detail_id)');
        $this->addSql('CREATE INDEX IDX_5A491BAB8DE820D9 ON selling (seller_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABED255ED6');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BABACD8E0EF');
        $this->addSql('ALTER TABLE selling DROP FOREIGN KEY FK_5A491BAB8DE820D9');
        $this->addSql('DROP INDEX IDX_5A491BABED255ED6 ON selling');
        $this->addSql('DROP INDEX IDX_5A491BABACD8E0EF ON selling');
        $this->addSql('DROP INDEX IDX_5A491BAB8DE820D9 ON selling');
        $this->addSql('ALTER TABLE selling ADD user_id_purchaser_id INT NOT NULL, ADD card_detail_id_id INT NOT NULL, ADD user_id_seller_id INT NOT NULL, DROP purchaser_id, DROP card_detail_id, DROP seller_id');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB1289FB0B FOREIGN KEY (card_detail_id_id) REFERENCES card_details (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BAB8D11E0FC FOREIGN KEY (user_id_seller_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE selling ADD CONSTRAINT FK_5A491BABDC38472B FOREIGN KEY (user_id_purchaser_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5A491BAB1289FB0B ON selling (card_detail_id_id)');
        $this->addSql('CREATE INDEX IDX_5A491BAB8D11E0FC ON selling (user_id_seller_id)');
        $this->addSql('CREATE INDEX IDX_5A491BABDC38472B ON selling (user_id_purchaser_id)');
    }
}
