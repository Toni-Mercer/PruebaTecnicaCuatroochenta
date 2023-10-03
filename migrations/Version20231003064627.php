<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003064627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reading_log CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE sensor CHANGE sensor_type_id sensor_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0D8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES sensor_type (id)');
        $this->addSql('CREATE INDEX IDX_BC8617B0D8550BD9 ON sensor (sensor_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0D8550BD9');
        $this->addSql('DROP INDEX IDX_BC8617B0D8550BD9 ON sensor');
        $this->addSql('ALTER TABLE sensor CHANGE sensor_type_id sensor_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE reading_log CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
