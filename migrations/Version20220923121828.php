<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923121828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0980109B4');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF09D86650F');
        $this->addSql('DROP INDEX IDX_8F91ABF09D86650F ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0980109B4 ON avis');
        $this->addSql('ALTER TABLE avis ADD user_id INT NOT NULL, ADD benne_id INT NOT NULL, DROP user_id_id, DROP benne_id_id');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0AF66A7F8 FOREIGN KEY (benne_id) REFERENCES benne (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0A76ED395 ON avis (user_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0AF66A7F8 ON avis (benne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0AF66A7F8');
        $this->addSql('DROP INDEX IDX_8F91ABF0A76ED395 ON avis');
        $this->addSql('DROP INDEX IDX_8F91ABF0AF66A7F8 ON avis');
        $this->addSql('ALTER TABLE avis ADD user_id_id INT NOT NULL, ADD benne_id_id INT NOT NULL, DROP user_id, DROP benne_id');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0980109B4 FOREIGN KEY (benne_id_id) REFERENCES benne (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF09D86650F ON avis (user_id_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0980109B4 ON avis (benne_id_id)');
    }
}
