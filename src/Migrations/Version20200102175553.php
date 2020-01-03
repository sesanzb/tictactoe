<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200102175553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, first_player_id INT NOT NULL, second_player_id INT NOT NULL, winner_id INT DEFAULT NULL, startdate DATETIME NOT NULL, enddate DATETIME DEFAULT NULL, INDEX IDX_232B318C65EB6591 (first_player_id), INDEX IDX_232B318CA40D7457 (second_player_id), INDEX IDX_232B318C5DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, dimension SMALLINT NOT NULL, UNIQUE INDEX UNIQ_58562B47E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, board_id INT NOT NULL, row SMALLINT NOT NULL, col SMALLINT NOT NULL, sign ENUM(\'x\', \'o\') NOT NULL COMMENT \'(DC2Type:marker_sign)\', INDEX IDX_82CF20FE99E6F5DF (player_id), INDEX IDX_82CF20FEE7EC5785 (board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, nickname VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_98197A65A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C65EB6591 FOREIGN KEY (first_player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA40D7457 FOREIGN KEY (second_player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B47E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE marker ADD CONSTRAINT FK_82CF20FE99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE marker ADD CONSTRAINT FK_82CF20FEE7EC5785 FOREIGN KEY (board_id) REFERENCES board (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B47E48FD905');
        $this->addSql('ALTER TABLE marker DROP FOREIGN KEY FK_82CF20FEE7EC5785');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C65EB6591');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA40D7457');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5DFCD4B8');
        $this->addSql('ALTER TABLE marker DROP FOREIGN KEY FK_82CF20FE99E6F5DF');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE board');
        $this->addSql('DROP TABLE marker');
        $this->addSql('DROP TABLE player');
    }
}
