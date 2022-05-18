<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508120435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic ADD autor_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B14D45BBE FOREIGN KEY (autor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9D40DE1B14D45BBE ON topic (autor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B14D45BBE');
        $this->addSql('DROP INDEX IDX_9D40DE1B14D45BBE ON topic');
        $this->addSql('ALTER TABLE topic DROP autor_id');
    }
}
