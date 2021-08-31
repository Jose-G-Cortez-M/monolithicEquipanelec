<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813165745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_close (id INT AUTO_INCREMENT NOT NULL, contract_number VARCHAR(100) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, registration_date DATETIME DEFAULT NULL, total_cost DOUBLE PRECISION DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, date LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', commercial_value DOUBLE PRECISION DEFAULT NULL, total_cost_task DOUBLE PRECISION DEFAULT NULL, total_cost_inventory DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project DROP state, DROP date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_close');
        $this->addSql('ALTER TABLE project ADD state VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD date LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
