<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125215543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venta DROP INDEX UNIQ_8FE7EE559F5A440B, ADD INDEX IDX_8FE7EE559F5A440B (estado_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venta DROP INDEX IDX_8FE7EE559F5A440B, ADD UNIQUE INDEX UNIQ_8FE7EE559F5A440B (estado_id)');
    }
}
