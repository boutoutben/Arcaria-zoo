<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704224232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD id_habitat INT DEFAULT NULL, ADD id_race INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FE5AA1B98 FOREIGN KEY (id_habitat) REFERENCES all_habitats (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F514FA7AD FOREIGN KEY (id_race) REFERENCES races (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FE5AA1B98');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F514FA7AD');
        $this->addSql('ALTER TABLE animal DROP id_habitat, DROP id_race');
    }
}
