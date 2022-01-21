<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121035911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE producto_carrito (producto_id INT NOT NULL, carrito_id INT NOT NULL, INDEX IDX_E62FF5ED7645698E (producto_id), INDEX IDX_E62FF5EDDE2CF6E7 (carrito_id), PRIMARY KEY(producto_id, carrito_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5ED7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5EDDE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE producto_carrito');
    }
}
