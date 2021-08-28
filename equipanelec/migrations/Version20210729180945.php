<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729180945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movement CHANGE tools_id tools_id INT NOT NULL, CHANGE materials_id materials_id INT NOT NULL, CHANGE cables_id cables_id INT NOT NULL, CHANGE projects_id projects_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movement CHANGE tools_id tools_id INT DEFAULT NULL, CHANGE materials_id materials_id INT DEFAULT NULL, CHANGE cables_id cables_id INT DEFAULT NULL, CHANGE projects_id projects_id INT DEFAULT NULL');
    }
}
