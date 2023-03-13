<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310081643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule ADD ajoute_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DDAA76F43 FOREIGN KEY (ajoute_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1DDAA76F43 ON vehicule (ajoute_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DDAA76F43');
        $this->addSql('DROP INDEX IDX_292FFF1DDAA76F43 ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP ajoute_par_id');
    }
}
