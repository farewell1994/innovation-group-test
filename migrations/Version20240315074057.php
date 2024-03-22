<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315074057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_bonus (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, bonus_id INT NOT NULL, date_create DATETIME NOT NULL, INDEX IDX_3CF5E3CD19EB6921 (client_id), INDEX IDX_3CF5E3CD69545666 (bonus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT client_bonus_to_client FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_bonus ADD CONSTRAINT client_bonus_to_bonus FOREIGN KEY (bonus_id) REFERENCES bonus (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY client_bonus_to_client');
        $this->addSql('ALTER TABLE client_bonus DROP FOREIGN KEY client_bonus_to_bonus');
        $this->addSql('DROP TABLE client_bonus');
    }
}
