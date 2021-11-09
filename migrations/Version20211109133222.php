<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211109133222 extends AbstractMigration
{
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
        $this->addSql('DROP INDEX UNIQ_1599687989D9B62 ON artist');
        $this->addSql('DROP INDEX UNIQ_881FC576989D9B62 ON artwork');
        $this->addSql('DROP INDEX UNIQ_64C19C1989D9B62 ON category');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA7989D9B62 ON event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event_artwork');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1599687989D9B62 ON artist (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_881FC576989D9B62 ON artwork (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA7989D9B62 ON event (slug)');
    }
}
