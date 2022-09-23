<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923123246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE benne ADD type_id_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5714819A0 FOREIGN KEY (type_id_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_ADC7E1D5714819A0 ON benne (type_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5714819A0');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_ADC7E1D5714819A0 ON benne');
        $this->addSql('ALTER TABLE benne ADD type VARCHAR(255) NOT NULL, DROP type_id_id');
    }
}
