<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105123722 extends AbstractMigration
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
        $this->addSql('ALTER TABLE artwork ADD picture_size INT DEFAULT NULL, ADD picture_name VARCHAR(255) DEFAULT NULL, DROP picture');
        $this->addSql('ALTER TABLE artist ADD photo_size INT DEFAULT NULL, ADD photo_name VARCHAR(255) DEFAULT NULL, DROP photo');
        $this->addSql('ALTER TABLE category ADD picture_size INT DEFAULT NULL, ADD picture_name VARCHAR(255) DEFAULT NULL, DROP picture');
        $this->addSql('ALTER TABLE event ADD picture_size INT DEFAULT NULL, ADD picture_name VARCHAR(255) DEFAULT NULL, DROP picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork ADD picture VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP picture_size, DROP picture_name');
        $this->addSql('ALTER TABLE artist ADD photo VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP photo_size, DROP photo_name');
        $this->addSql('ALTER TABLE category ADD picture VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP picture_size, DROP picture_name');
        $this->addSql('ALTER TABLE event ADD picture VARCHAR(512) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP picture_size, DROP picture_name');
    }
}
