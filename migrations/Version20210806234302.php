<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806234302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_task (project_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_6BEF133D166D1F9C (project_id), INDEX IDX_6BEF133D8DB60186 (task_id), PRIMARY KEY(project_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_task ADD CONSTRAINT FK_6BEF133D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_task ADD CONSTRAINT FK_6BEF133D8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_task ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_task ADD statetask VARCHAR(20) DEFAULT NULL');
        $this->addSql('DROP TABLE task_project');
        $this->addSql('ALTER TABLE movement ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD state VARCHAR(25) DEFAULT NULL, ADD date LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_project (task_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_3052FA048DB60186 (task_id), INDEX IDX_3052FA04166D1F9C (project_id), PRIMARY KEY(task_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE task_project ADD CONSTRAINT FK_3052FA04166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_project ADD CONSTRAINT FK_3052FA048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE project_task');
        $this->addSql('ALTER TABLE movement DROP description');
        $this->addSql('ALTER TABLE project DROP state, DROP date');
    }
}
