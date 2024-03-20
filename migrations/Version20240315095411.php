<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315095411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY FK_3CF5E3CD19EB6921');
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY FK_3CF5E3CD69545666');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT FK_3CF5E3CD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT FK_3CF5E3CD69545666 FOREIGN KEY (bonus_id) REFERENCES bonus (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY FK_3CF5E3CD19EB6921');
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY FK_3CF5E3CD69545666');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT FK_3CF5E3CD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT FK_3CF5E3CD69545666 FOREIGN KEY (bonus_id) REFERENCES bonus (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
