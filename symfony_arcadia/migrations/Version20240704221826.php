<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704221826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP id_race, DROP id_habitats, CHANGE id_rapport_veterinaire id_habitat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FE5AA1B98 FOREIGN KEY (id_habitat) REFERENCES all_habitats (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FE5AA1B98');
        $this->addSql('ALTER TABLE animal ADD id_race INT NOT NULL, ADD id_habitats INT NOT NULL, CHANGE id_habitat id_rapport_veterinaire INT DEFAULT NULL');
    }
}
