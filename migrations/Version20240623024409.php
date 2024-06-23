<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623024409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A71DC132');
        $this->addSql('DROP INDEX IDX_23A0E66A71DC132 ON article');
        $this->addSql('ALTER TABLE article DROP commantaires_id');
        $this->addSql('ALTER TABLE commentaire ADD articles_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC1EBAF6CC ON commentaire (articles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD commantaires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A71DC132 FOREIGN KEY (commantaires_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A71DC132 ON article (commantaires_id)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC1EBAF6CC');
        $this->addSql('DROP INDEX IDX_67F068BC1EBAF6CC ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP articles_id');
    }
}
