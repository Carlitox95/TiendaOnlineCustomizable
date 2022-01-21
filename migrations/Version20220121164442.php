<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121164442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_producto DROP FOREIGN KEY FK_96D7E7053397707A');
        $this->addSql('ALTER TABLE categoria_producto DROP FOREIGN KEY FK_96D7E7057645698E');
        $this->addSql('ALTER TABLE categoria_producto ADD CONSTRAINT FK_96D7E7053397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categoria_producto ADD CONSTRAINT FK_96D7E7057645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto_carrito DROP FOREIGN KEY FK_E62FF5ED7645698E');
        $this->addSql('ALTER TABLE producto_carrito DROP FOREIGN KEY FK_E62FF5EDDE2CF6E7');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5ED7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5EDDE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_producto DROP FOREIGN KEY FK_96D7E7053397707A');
        $this->addSql('ALTER TABLE categoria_producto DROP FOREIGN KEY FK_96D7E7057645698E');
        $this->addSql('ALTER TABLE categoria_producto ADD CONSTRAINT FK_96D7E7053397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE categoria_producto ADD CONSTRAINT FK_96D7E7057645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE producto_carrito DROP FOREIGN KEY FK_E62FF5ED7645698E');
        $this->addSql('ALTER TABLE producto_carrito DROP FOREIGN KEY FK_E62FF5EDDE2CF6E7');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5ED7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5EDDE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id)');
    }
}
