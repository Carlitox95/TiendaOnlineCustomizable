<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125194645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE direccion (id INT AUTO_INCREMENT NOT NULL, calle VARCHAR(255) NOT NULL, entrecalle1 VARCHAR(255) NOT NULL, entrecalle2 VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, codigopostal VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, provincia VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD direccion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D0A7BD7 FOREIGN KEY (direccion_id) REFERENCES direccion (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D0A7BD7 ON user (direccion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D0A7BD7');
        $this->addSql('DROP TABLE direccion');
        $this->addSql('DROP INDEX UNIQ_8D93D649D0A7BD7 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP direccion_id');
    }
}
