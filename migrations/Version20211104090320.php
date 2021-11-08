<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104090320 extends AbstractMigration
{
    public function isTransactional(): bool
    {
        return false;
    }
    
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, biography LONGTEXT NOT NULL, country VARCHAR(255) NOT NULL, photo VARCHAR(512) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, artists_id INT NOT NULL, title VARCHAR(255) NOT NULL, picture VARCHAR(512) NOT NULL, height INT DEFAULT NULL, width INT DEFAULT NULL, depth INT DEFAULT NULL, description VARCHAR(1024) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_881FC57654A05007 (artists_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork_category (artwork_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_FA06D53FDB8FFA4 (artwork_id), INDEX IDX_FA06D53F12469DE2 (category_id), PRIMARY KEY(artwork_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork_event (artwork_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_AA4462BDDB8FFA4 (artwork_id), INDEX IDX_AA4462BD71F7E88B (event_id), PRIMARY KEY(artwork_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', picture VARCHAR(512) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, information LONGTEXT NOT NULL, date DATETIME NOT NULL, link VARCHAR(255) DEFAULT NULL, latitude NUMERIC(18, 8) DEFAULT NULL, longitude NUMERIC(19, 8) DEFAULT NULL, road_number INT DEFAULT NULL, road_name VARCHAR(255) NOT NULL, road_name2 VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(20) NOT NULL, town VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', picture VARCHAR(512) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_artist (event_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_33C0E1D571F7E88B (event_id), INDEX IDX_33C0E1D5B7970CF8 (artist_id), PRIMARY KEY(event_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC57654A05007 FOREIGN KEY (artists_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53FDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_event ADD CONSTRAINT FK_AA4462BDDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_event ADD CONSTRAINT FK_AA4462BD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_artist ADD CONSTRAINT FK_33C0E1D571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_artist ADD CONSTRAINT FK_33C0E1D5B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC57654A05007');
        $this->addSql('ALTER TABLE event_artist DROP FOREIGN KEY FK_33C0E1D5B7970CF8');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53FDB8FFA4');
        $this->addSql('ALTER TABLE artwork_event DROP FOREIGN KEY FK_AA4462BDDB8FFA4');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F12469DE2');
        $this->addSql('ALTER TABLE artwork_event DROP FOREIGN KEY FK_AA4462BD71F7E88B');
        $this->addSql('ALTER TABLE event_artist DROP FOREIGN KEY FK_33C0E1D571F7E88B');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE artwork_category');
        $this->addSql('DROP TABLE artwork_event');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_artist');
        $this->addSql('DROP TABLE `user`');
    }
}
