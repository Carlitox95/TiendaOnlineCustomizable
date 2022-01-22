<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122221434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estadoventa (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venta (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, estado_id INT DEFAULT NULL, fecha DATETIME NOT NULL, articulos LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', INDEX IDX_8FE7EE55DB38439E (usuario_id), UNIQUE INDEX UNIQ_8FE7EE559F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55DB38439E FOREIGN KEY (usuario_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE559F5A440B FOREIGN KEY (estado_id) REFERENCES estadoventa (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE559F5A440B');
        $this->addSql('DROP TABLE estadoventa');
        $this->addSql('DROP TABLE venta');
    }
}
