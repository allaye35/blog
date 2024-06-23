<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623175651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_article (categorie_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_5DB9A0C4BCF5E72D (categorie_id), INDEX IDX_5DB9A0C47294869C (article_id), PRIMARY KEY(categorie_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_role (utilisateur_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9EE8E650FB88E14F (utilisateur_id), INDEX IDX_9EE8E650D60322AC (role_id), PRIMARY KEY(utilisateur_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_article ADD CONSTRAINT FK_5DB9A0C4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_article ADD CONSTRAINT FK_5DB9A0C47294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_role ADD CONSTRAINT FK_9EE8E650FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_role ADD CONSTRAINT FK_9EE8E650D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_mots_cles DROP FOREIGN KEY FK_ED196EEC0BE80DB');
        $this->addSql('ALTER TABLE article_mots_cles DROP FOREIGN KEY FK_ED196EE7294869C');
        $this->addSql('DROP TABLE article_mots_cles');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FB88E14F');
        $this->addSql('DROP INDEX IDX_23A0E66FB88E14F ON article');
        $this->addSql('ALTER TABLE article ADD email VARCHAR(255) NOT NULL, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE contenu contenu LONGTEXT NOT NULL, CHANGE utilisateur_id mots_cles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66C0BE80DB ON article (mots_cles_id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFB88E14F');
        $this->addSql('DROP INDEX IDX_67F068BCFB88E14F ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP utilisateur_id, CHANGE commentaire commentaire VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mots_cles CHANGE mot mot VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3D60322AC');
        $this->addSql('DROP INDEX IDX_1D1C63B3D60322AC ON utilisateur');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD articles_id INT DEFAULT NULL, ADD date_creation DATETIME NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL, CHANGE role_id commentaires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B317C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B31EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B317C4B2B0 ON utilisateur (commentaires_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B31EBAF6CC ON utilisateur (articles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_mots_cles (article_id INT NOT NULL, mots_cles_id INT NOT NULL, INDEX IDX_ED196EE7294869C (article_id), INDEX IDX_ED196EEC0BE80DB (mots_cles_id), PRIMARY KEY(article_id, mots_cles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article_mots_cles ADD CONSTRAINT FK_ED196EEC0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_mots_cles ADD CONSTRAINT FK_ED196EE7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_article DROP FOREIGN KEY FK_5DB9A0C4BCF5E72D');
        $this->addSql('ALTER TABLE categorie_article DROP FOREIGN KEY FK_5DB9A0C47294869C');
        $this->addSql('ALTER TABLE utilisateur_role DROP FOREIGN KEY FK_9EE8E650FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_role DROP FOREIGN KEY FK_9EE8E650D60322AC');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_article');
        $this->addSql('DROP TABLE utilisateur_role');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C0BE80DB');
        $this->addSql('DROP INDEX IDX_23A0E66C0BE80DB ON article');
        $this->addSql('ALTER TABLE article DROP email, CHANGE titre titre LONGTEXT NOT NULL, CHANGE contenu contenu LONGTEXT DEFAULT NULL, CHANGE mots_cles_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66FB88E14F ON article (utilisateur_id)');
        $this->addSql('ALTER TABLE commentaire ADD utilisateur_id INT DEFAULT NULL, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCFB88E14F ON commentaire (utilisateur_id)');
        $this->addSql('ALTER TABLE mots_cles CHANGE mot mot LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B317C4B2B0');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B31EBAF6CC');
        $this->addSql('DROP INDEX IDX_1D1C63B317C4B2B0 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B31EBAF6CC ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD role_id INT DEFAULT NULL, ADD roles JSON NOT NULL, DROP commentaires_id, DROP articles_id, DROP date_creation, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D60322AC ON utilisateur (role_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }
}
