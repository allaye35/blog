<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623215506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_mots_cles (article_id INT NOT NULL, mots_cles_id INT NOT NULL, INDEX IDX_ED196EE7294869C (article_id), INDEX IDX_ED196EEC0BE80DB (mots_cles_id), PRIMARY KEY(article_id, mots_cles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_mots_cles ADD CONSTRAINT FK_ED196EE7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_mots_cles ADD CONSTRAINT FK_ED196EEC0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C0BE80DB');
        $this->addSql('DROP INDEX IDX_23A0E66C0BE80DB ON article');
        $this->addSql('ALTER TABLE article DROP mots_cles_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_mots_cles DROP FOREIGN KEY FK_ED196EE7294869C');
        $this->addSql('ALTER TABLE article_mots_cles DROP FOREIGN KEY FK_ED196EEC0BE80DB');
        $this->addSql('DROP TABLE article_mots_cles');
        $this->addSql('ALTER TABLE article ADD mots_cles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66C0BE80DB ON article (mots_cles_id)');
    }
}
