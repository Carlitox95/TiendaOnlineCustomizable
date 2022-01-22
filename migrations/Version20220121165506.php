<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121165506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE productos_carrito (id INT AUTO_INCREMENT NOT NULL, cantidad INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrito ADD productos_carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carrito ADD CONSTRAINT FK_77E6BED5743CED5C FOREIGN KEY (productos_carrito_id) REFERENCES productos_carrito (id)');
        $this->addSql('CREATE INDEX IDX_77E6BED5743CED5C ON carrito (productos_carrito_id)');
        $this->addSql('ALTER TABLE producto ADD productos_carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615743CED5C FOREIGN KEY (productos_carrito_id) REFERENCES productos_carrito (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615743CED5C ON producto (productos_carrito_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrito DROP FOREIGN KEY FK_77E6BED5743CED5C');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615743CED5C');
        $this->addSql('DROP TABLE productos_carrito');
        $this->addSql('DROP INDEX IDX_77E6BED5743CED5C ON carrito');
        $this->addSql('ALTER TABLE carrito DROP productos_carrito_id');
        $this->addSql('DROP INDEX IDX_A7BB0615743CED5C ON producto');
        $this->addSql('ALTER TABLE producto DROP productos_carrito_id');
    }
}
