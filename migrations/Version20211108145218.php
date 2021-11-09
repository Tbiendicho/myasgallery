<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108145218 extends AbstractMigration
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
        $this->addSql('ALTER TABLE artwork ADD picture_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE artist ADD photo_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD picture_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD picture_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork DROP picture_url');
        $this->addSql('ALTER TABLE artist DROP photo_url');
        $this->addSql('ALTER TABLE category DROP picture_url');
        $this->addSql('ALTER TABLE event DROP picture_url');
    }
}
