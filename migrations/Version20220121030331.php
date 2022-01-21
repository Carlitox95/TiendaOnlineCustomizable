<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121030331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, monto DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_77E6BED5DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrito ADD CONSTRAINT FK_77E6BED5DB38439E FOREIGN KEY (usuario_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE producto ADD carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615DE2CF6E7 FOREIGN KEY (carrito_id) REFERENCES carrito (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615DE2CF6E7 ON producto (carrito_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615DE2CF6E7');
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP INDEX IDX_A7BB0615DE2CF6E7 ON producto');
        $this->addSql('ALTER TABLE producto DROP carrito_id');
    }
}
