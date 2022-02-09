<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209220457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE producto_categoria (producto_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_B881A7077645698E (producto_id), INDEX IDX_B881A7073397707A (categoria_id), PRIMARY KEY(producto_id, categoria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producto_categoria ADD CONSTRAINT FK_B881A7077645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto_categoria ADD CONSTRAINT FK_B881A7073397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE producto_categoria');
        $this->addSql('ALTER TABLE categoria CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripcion descripcion LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE configuracion CHANGE mensaje mensaje LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tipo tipo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE direccion CHANGE calle calle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE entrecalle1 entrecalle1 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE entrecalle2 entrecalle2 VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE numero numero VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE codigopostal codigopostal VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ciudad ciudad VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE provincia provincia VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE estadoventa CHANGE estado estado VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE imagen CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url url LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE producto CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripcion descripcion LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripcion_completa descripcion_completa VARCHAR(2500) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE codigo codigo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mail mail VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE venta CHANGE articulos articulos LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:object)\'');
    }
}
