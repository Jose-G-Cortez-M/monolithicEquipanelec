<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803033822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cable ADD purchase_price DOUBLE PRECISION NOT NULL, ADD sale_price DOUBLE PRECISION NOT NULL, DROP purcharseprice, DROP saleprice, CHANGE weightpermeter weight_per_meter DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cable ADD purcharseprice DOUBLE PRECISION NOT NULL, ADD saleprice DOUBLE PRECISION NOT NULL, DROP purchase_price, DROP sale_price, CHANGE weight_per_meter weightpermeter DOUBLE PRECISION DEFAULT NULL');
    }
}
