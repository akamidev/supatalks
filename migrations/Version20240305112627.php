<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305112627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, name, date, price, location, theme, attendee FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(80) NOT NULL, date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, location VARCHAR(80) NOT NULL, theme VARCHAR(80) NOT NULL, attendee VARCHAR(80) NOT NULL)');
        $this->addSql('INSERT INTO event (id, name, date, price, location, theme, attendee) SELECT id, name, date, price, location, theme, attendee FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, name, price, location, theme, attendee, date FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(80) NOT NULL, price NUMERIC(10, 2) NOT NULL, location VARCHAR(80) NOT NULL, theme VARCHAR(80) NOT NULL, attendee VARCHAR(80) NOT NULL, date VARCHAR(80) NOT NULL)');
        $this->addSql('INSERT INTO event (id, name, price, location, theme, attendee, date) SELECT id, name, price, location, theme, attendee, date FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }
}
