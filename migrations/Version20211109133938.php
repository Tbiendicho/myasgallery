<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211109133938 extends AbstractMigration
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
        $this->addSql('CREATE TABLE event_artwork (event_id INT NOT NULL, artwork_id INT NOT NULL, INDEX IDX_D486CD971F7E88B (event_id), INDEX IDX_D486CD9DB8FFA4 (artwork_id), PRIMARY KEY(event_id, artwork_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_artwork ADD CONSTRAINT FK_D486CD971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_artwork ADD CONSTRAINT FK_D486CD9DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE artwork_event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork_event (artwork_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_AA4462BDDB8FFA4 (artwork_id), INDEX IDX_AA4462BD71F7E88B (event_id), PRIMARY KEY(artwork_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artwork_event ADD CONSTRAINT FK_AA4462BD71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_event ADD CONSTRAINT FK_AA4462BDDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE event_artwork');
    }
}
