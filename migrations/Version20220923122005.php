<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923122005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5B65C2D26');
        $this->addSql('DROP INDEX IDX_ADC7E1D5B65C2D26 ON benne');
        $this->addSql('ALTER TABLE benne CHANGE localisation_id_id localisation_id INT NOT NULL');
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('CREATE INDEX IDX_ADC7E1D5C68BE09C ON benne (localisation_id)');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B55114980109B4');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551149D86650F');
        $this->addSql('DROP INDEX IDX_F4B551149D86650F ON signalement');
        $this->addSql('DROP INDEX IDX_F4B55114980109B4 ON signalement');
        $this->addSql('ALTER TABLE signalement ADD user_id INT NOT NULL, ADD benne_id INT NOT NULL, DROP user_id_id, DROP benne_id_id');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B55114A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B55114AF66A7F8 FOREIGN KEY (benne_id) REFERENCES benne (id)');
        $this->addSql('CREATE INDEX IDX_F4B55114A76ED395 ON signalement (user_id)');
        $this->addSql('CREATE INDEX IDX_F4B55114AF66A7F8 ON signalement (benne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5C68BE09C');
        $this->addSql('DROP INDEX IDX_ADC7E1D5C68BE09C ON benne');
        $this->addSql('ALTER TABLE benne CHANGE localisation_id localisation_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5B65C2D26 FOREIGN KEY (localisation_id_id) REFERENCES localisation (id)');
        $this->addSql('CREATE INDEX IDX_ADC7E1D5B65C2D26 ON benne (localisation_id_id)');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B55114A76ED395');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B55114AF66A7F8');
        $this->addSql('DROP INDEX IDX_F4B55114A76ED395 ON signalement');
        $this->addSql('DROP INDEX IDX_F4B55114AF66A7F8 ON signalement');
        $this->addSql('ALTER TABLE signalement ADD user_id_id INT NOT NULL, ADD benne_id_id INT NOT NULL, DROP user_id, DROP benne_id');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B55114980109B4 FOREIGN KEY (benne_id_id) REFERENCES benne (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551149D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4B551149D86650F ON signalement (user_id_id)');
        $this->addSql('CREATE INDEX IDX_F4B55114980109B4 ON signalement (benne_id_id)');
    }
}
