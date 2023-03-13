<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309144348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD cree_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FC29C013 FOREIGN KEY (cree_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66FC29C013 ON article (cree_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FC29C013');
        $this->addSql('DROP INDEX IDX_23A0E66FC29C013 ON article');
        $this->addSql('ALTER TABLE article DROP cree_par_id');
    }
}
