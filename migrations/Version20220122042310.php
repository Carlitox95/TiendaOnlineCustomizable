<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122042310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen DROP FOREIGN KEY FK_8319D2B37645698E');
        $this->addSql('DROP INDEX IDX_8319D2B37645698E ON imagen');
        $this->addSql('ALTER TABLE imagen DROP producto_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imagen ADD producto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE imagen ADD CONSTRAINT FK_8319D2B37645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('CREATE INDEX IDX_8319D2B37645698E ON imagen (producto_id)');
    }
}
