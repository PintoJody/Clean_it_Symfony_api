<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923114643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, city_name VARCHAR(255) NOT NULL, departement_name VARCHAR(255) NOT NULL, region_name VARCHAR(255) NOT NULL, departement_code INT NOT NULL, region_code INT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_localisation (user_id INT NOT NULL, localisation_id INT NOT NULL, INDEX IDX_3F1FB28DA76ED395 (user_id), INDEX IDX_3F1FB28DC68BE09C (localisation_id), PRIMARY KEY(user_id, localisation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_localisation ADD CONSTRAINT FK_3F1FB28DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_localisation ADD CONSTRAINT FK_3F1FB28DC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_localisation DROP FOREIGN KEY FK_3F1FB28DA76ED395');
        $this->addSql('ALTER TABLE user_localisation DROP FOREIGN KEY FK_3F1FB28DC68BE09C');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE user_localisation');
    }
}
