<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003082918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reading_log ADD reading_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reading_log ADD CONSTRAINT FK_16CCC2E527275CD FOREIGN KEY (reading_id) REFERENCES reading (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16CCC2E527275CD ON reading_log (reading_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reading_log DROP FOREIGN KEY FK_16CCC2E527275CD');
        $this->addSql('DROP INDEX UNIQ_16CCC2E527275CD ON reading_log');
        $this->addSql('ALTER TABLE reading_log DROP reading_id');
    }
}
