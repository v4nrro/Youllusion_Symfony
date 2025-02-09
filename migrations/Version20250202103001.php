<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202103001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publicaciones ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE publicaciones ADD CONSTRAINT FK_A3A706C0DB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_A3A706C0DB38439E ON publicaciones (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publicaciones DROP FOREIGN KEY FK_A3A706C0DB38439E');
        $this->addSql('DROP INDEX IDX_A3A706C0DB38439E ON publicaciones');
        $this->addSql('ALTER TABLE publicaciones DROP usuario_id');
    }
}
