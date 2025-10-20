<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020142740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD publish_date DATE DEFAULT NULL, DROP categorie, DROP date_publication, CHANGE author_id author_id INT DEFAULT NULL, CHANGE title title VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD categorie VARCHAR(255) NOT NULL, ADD date_publication DATETIME NOT NULL, DROP publish_date, CHANGE author_id author_id INT NOT NULL, CHANGE title title VARCHAR(255) NOT NULL');
    }
}
