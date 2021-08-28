<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729061137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cable (id INT AUTO_INCREMENT NOT NULL, barcode VARCHAR(150) DEFAULT NULL, name VARCHAR(100) NOT NULL, availablemeter DOUBLE PRECISION NOT NULL, weightpermeter DOUBLE PRECISION DEFAULT NULL, purcharseprice DOUBLE PRECISION NOT NULL, saleprice DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, comapny VARCHAR(100) DEFAULT NULL, representative VARCHAR(100) NOT NULL, phone VARCHAR(50) DEFAULT NULL, direction VARCHAR(150) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, barcode VARCHAR(150) DEFAULT NULL, name VARCHAR(100) NOT NULL, stock DOUBLE PRECISION NOT NULL, location LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, brand VARCHAR(50) DEFAULT NULL, purchaseprice DOUBLE PRECISION NOT NULL, saleprice DOUBLE PRECISION NOT NULL, minimumlimit DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, tools_id INT DEFAULT NULL, materials_id INT DEFAULT NULL, cables_id INT DEFAULT NULL, projects_id INT DEFAULT NULL, orderdate DATETIME NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_F4DD95F7752C489C (tools_id), INDEX IDX_F4DD95F73A9FC940 (materials_id), INDEX IDX_F4DD95F74DE1706A (cables_id), INDEX IDX_F4DD95F71EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, clients_id INT DEFAULT NULL, contractnumber VARCHAR(100) DEFAULT NULL, name VARCHAR(100) NOT NULL, registrationdate DATETIME NOT NULL, startdate DATETIME DEFAULT NULL, endtime DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, advances DOUBLE PRECISION DEFAULT NULL, totalcost DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2FB3D0EEAB014612 (clients_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, timeperminute DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, costpertask DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_project (task_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_3052FA048DB60186 (task_id), INDEX IDX_3052FA04166D1F9C (project_id), PRIMARY KEY(task_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, barcode VARCHAR(150) DEFAULT NULL, name VARCHAR(100) NOT NULL, stock DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, brand VARCHAR(50) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, phone VARCHAR(50) DEFAULT NULL, salary DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7752C489C FOREIGN KEY (tools_id) REFERENCES tool (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F73A9FC940 FOREIGN KEY (materials_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F74DE1706A FOREIGN KEY (cables_id) REFERENCES cable (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F71EDE0F55 FOREIGN KEY (projects_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEAB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_project ADD CONSTRAINT FK_3052FA048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_project ADD CONSTRAINT FK_3052FA04166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F74DE1706A');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEAB014612');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F73A9FC940');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F71EDE0F55');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE task_project DROP FOREIGN KEY FK_3052FA04166D1F9C');
        $this->addSql('ALTER TABLE task_project DROP FOREIGN KEY FK_3052FA048DB60186');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7752C489C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('DROP TABLE cable');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_project');
        $this->addSql('DROP TABLE tool');
        $this->addSql('DROP TABLE user');
    }
}
