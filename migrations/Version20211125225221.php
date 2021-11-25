<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125225221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cupon (id INT AUTO_INCREMENT NOT NULL, registrado_por_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, fecha_registro DATETIME NOT NULL, fecha_vencimiento DATETIME NOT NULL, estado VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, token VARCHAR(1000) DEFAULT NULL, INDEX IDX_58CFF949EC7D893C (registrado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cupon ADD CONSTRAINT FK_58CFF949EC7D893C FOREIGN KEY (registrado_por_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cupon');
    }
}
