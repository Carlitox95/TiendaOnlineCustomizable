<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121213427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrito DROP FOREIGN KEY FK_77E6BED5743CED5C');
        $this->addSql('DROP INDEX IDX_77E6BED5743CED5C ON carrito');
        $this->addSql('ALTER TABLE carrito DROP productos_carrito_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrito ADD productos_carrito_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carrito ADD CONSTRAINT FK_77E6BED5743CED5C FOREIGN KEY (productos_carrito_id) REFERENCES productos_carrito (id)');
        $this->addSql('CREATE INDEX IDX_77E6BED5743CED5C ON carrito (productos_carrito_id)');
    }
}
