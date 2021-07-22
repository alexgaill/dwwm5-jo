<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722072554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, discipline_id INTEGER NOT NULL, pays_id INTEGER NOT NULL, nom VARCHAR(65) NOT NULL, prenom VARCHAR(65) NOT NULL, date_naissance DATE NOT NULL, photo VARCHAR(40) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C03B8321A5522701 ON athlete (discipline_id)');
        $this->addSql('CREATE INDEX IDX_C03B8321A6E44244 ON athlete (pays_id)');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nombre_candidats INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('CREATE TABLE pays (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, drapeau VARCHAR(50) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE athlete');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE pays');
    }
}
