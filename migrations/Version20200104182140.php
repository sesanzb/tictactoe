<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104182140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE board (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, dimension SMALLINT NOT NULL, game_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_58562B47E48FD905 ON board (game_id)');
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, startdate DATETIME NOT NULL, enddate DATETIME DEFAULT NULL, first_player_id INTEGER NOT NULL, second_player_id INTEGER NOT NULL, winner_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE marker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, "row" SMALLINT NOT NULL, col SMALLINT NOT NULL, sign VARCHAR(1) NOT NULL, player_id INTEGER NOT NULL, board_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX marker_position_uk ON marker (board_id, "row", col)');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, nickname VARCHAR(30) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65A188FE64 ON player (nickname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE board');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE marker');
        $this->addSql('DROP TABLE player');
    }
}
