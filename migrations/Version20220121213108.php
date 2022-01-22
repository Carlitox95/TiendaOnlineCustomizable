<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121213108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE producto_carrito');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615743CED5C');
        $this->addSql('DROP INDEX IDX_A7BB0615743CED5C ON producto');
        $this->addSql('ALTER TABLE producto DROP productos_carrito_id');
        $this->addSql('ALTER TABLE productos_carrito ADD producto_id INT DEFAULT NULL, ADD carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos_carrito ADD CONSTRAINT FK_4FF85FCA7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE productos_carrito ADD CONSTRAINT FK_4FF85FCADE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id)');
        $this->addSql('CREATE INDEX IDX_4FF85FCA7645698E ON productos_carrito (producto_id)');
        $this->addSql('CREATE INDEX IDX_4FF85FCADE2CF6E7 ON productos_carrito (carrito_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE producto_carrito (producto_id INT NOT NULL, carrito_id INT NOT NULL, INDEX IDX_E62FF5ED7645698E (producto_id), INDEX IDX_E62FF5EDDE2CF6E7 (carrito_id), PRIMARY KEY(producto_id, carrito_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5ED7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto_carrito ADD CONSTRAINT FK_E62FF5EDDE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto ADD productos_carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615743CED5C FOREIGN KEY (productos_carrito_id) REFERENCES productos_carrito (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615743CED5C ON producto (productos_carrito_id)');
        $this->addSql('ALTER TABLE productos_carrito DROP FOREIGN KEY FK_4FF85FCA7645698E');
        $this->addSql('ALTER TABLE productos_carrito DROP FOREIGN KEY FK_4FF85FCADE2CF6E7');
        $this->addSql('DROP INDEX IDX_4FF85FCA7645698E ON productos_carrito');
        $this->addSql('DROP INDEX IDX_4FF85FCADE2CF6E7 ON productos_carrito');
        $this->addSql('ALTER TABLE productos_carrito DROP producto_id, DROP carrito_id');
    }
}
