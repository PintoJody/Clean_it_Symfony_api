<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206085109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5D5E86FF FOREIGN KEY (etat_id) REFERENCES etat_benne (id)');
        $this->addSql('CREATE INDEX IDX_ADC7E1D5D5E86FF ON benne (etat_id)');
        $this->addSql('ALTER TABLE user ADD picture VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5D5E86FF');
        $this->addSql('DROP INDEX IDX_ADC7E1D5D5E86FF ON benne');
        $this->addSql('ALTER TABLE user DROP picture');
    }
}
