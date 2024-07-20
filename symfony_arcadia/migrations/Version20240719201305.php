<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240719201305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD id_last_rapport INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FFB79E9A6 FOREIGN KEY (id_last_rapport) REFERENCES rapport_veterinaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP INDEX UNIQ_6AAB231FE5AA1B98, ADD INDEX FK_6AAB231FE5AA1B98 (id_habitat)');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FFB79E9A6');
        $this->addSql('ALTER TABLE animal DROP id_last_rapport');
    }
}
