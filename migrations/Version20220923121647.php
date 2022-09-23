<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923121647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, benne_id_id INT NOT NULL, nbr_star INT NOT NULL, INDEX IDX_8F91ABF09D86650F (user_id_id), INDEX IDX_8F91ABF0980109B4 (benne_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE benne (id INT AUTO_INCREMENT NOT NULL, localisation_id_id INT NOT NULL, capacite VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_ADC7E1D5B65C2D26 (localisation_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE signalement (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, benne_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F4B551149D86650F (user_id_id), INDEX IDX_F4B55114980109B4 (benne_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0980109B4 FOREIGN KEY (benne_id_id) REFERENCES benne (id)');
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5B65C2D26 FOREIGN KEY (localisation_id_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B551149D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE signalement ADD CONSTRAINT FK_F4B55114980109B4 FOREIGN KEY (benne_id_id) REFERENCES benne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09D86650F');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0980109B4');
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5B65C2D26');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B551149D86650F');
        $this->addSql('ALTER TABLE signalement DROP FOREIGN KEY FK_F4B55114980109B4');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE benne');
        $this->addSql('DROP TABLE signalement');
    }
}
