<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722075022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C03B8321A6E44244');
        $this->addSql('DROP INDEX IDX_C03B8321A5522701');
        $this->addSql('CREATE TEMPORARY TABLE __temp__athlete AS SELECT id, discipline_id, pays_id, nom, prenom, date_naissance, photo FROM athlete');
        $this->addSql('DROP TABLE athlete');
        $this->addSql('CREATE TABLE athlete (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, discipline_id INTEGER NOT NULL, pays_id INTEGER NOT NULL, nom VARCHAR(65) NOT NULL COLLATE BINARY, prenom VARCHAR(65) NOT NULL COLLATE BINARY, date_naissance DATE NOT NULL, photo VARCHAR(40) NOT NULL COLLATE BINARY, CONSTRAINT FK_C03B8321A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C03B8321A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO athlete (id, discipline_id, pays_id, nom, prenom, date_naissance, photo) SELECT id, discipline_id, pays_id, nom, prenom, date_naissance, photo FROM __temp__athlete');
        $this->addSql('DROP TABLE __temp__athlete');
        $this->addSql('CREATE INDEX IDX_C03B8321A6E44244 ON athlete (pays_id)');
        $this->addSql('CREATE INDEX IDX_C03B8321A5522701 ON athlete (discipline_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__discipline AS SELECT id, nom, nombre_candidats FROM discipline');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL COLLATE BINARY, nombre_candidats INTEGER DEFAULT 0)');
        $this->addSql('INSERT INTO discipline (id, nom, nombre_candidats) SELECT id, nom, nombre_candidats FROM __temp__discipline');
        $this->addSql('DROP TABLE __temp__discipline');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C03B8321A5522701');
        $this->addSql('DROP INDEX IDX_C03B8321A6E44244');
        $this->addSql('CREATE TEMPORARY TABLE __temp__athlete AS SELECT id, discipline_id, pays_id, nom, prenom, date_naissance, photo FROM athlete');
        $this->addSql('DROP TABLE athlete');
        $this->addSql('CREATE TABLE athlete (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, discipline_id INTEGER NOT NULL, pays_id INTEGER NOT NULL, nom VARCHAR(65) NOT NULL, prenom VARCHAR(65) NOT NULL, date_naissance DATE NOT NULL, photo VARCHAR(40) NOT NULL)');
        $this->addSql('INSERT INTO athlete (id, discipline_id, pays_id, nom, prenom, date_naissance, photo) SELECT id, discipline_id, pays_id, nom, prenom, date_naissance, photo FROM __temp__athlete');
        $this->addSql('DROP TABLE __temp__athlete');
        $this->addSql('CREATE INDEX IDX_C03B8321A5522701 ON athlete (discipline_id)');
        $this->addSql('CREATE INDEX IDX_C03B8321A6E44244 ON athlete (pays_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__discipline AS SELECT id, nom, nombre_candidats FROM discipline');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('CREATE TABLE discipline (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nombre_candidats INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO discipline (id, nom, nombre_candidats) SELECT id, nom, nombre_candidats FROM __temp__discipline');
        $this->addSql('DROP TABLE __temp__discipline');
    }
}
