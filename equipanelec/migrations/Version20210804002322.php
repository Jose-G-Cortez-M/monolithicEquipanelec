<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210804002322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD start_date DATETIME DEFAULT NULL, ADD end_time DATETIME DEFAULT NULL, DROP startdate, DROP endtime, CHANGE contractnumber contract_number VARCHAR(100) DEFAULT NULL, CHANGE registrationdate registration_date DATETIME NOT NULL, CHANGE totalcost total_cost DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD time_per_minute DOUBLE PRECISION NOT NULL, ADD cost_per_task DOUBLE PRECISION NOT NULL, DROP timeperminute, DROP costpertask');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD startdate DATETIME DEFAULT NULL, ADD endtime DATETIME DEFAULT NULL, DROP start_date, DROP end_time, CHANGE contract_number contractnumber VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE registration_date registrationdate DATETIME NOT NULL, CHANGE total_cost totalcost DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD timeperminute DOUBLE PRECISION NOT NULL, ADD costpertask DOUBLE PRECISION NOT NULL, DROP time_per_minute, DROP cost_per_task');
    }
}
