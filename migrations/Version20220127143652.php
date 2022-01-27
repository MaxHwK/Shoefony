<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127143652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sto_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sto_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sto_image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sto_product (id INT AUTO_INCREMENT NOT NULL, sto_image_id INT NOT NULL, sto_brand_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, long_description VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B21FD430B37A9F44 (sto_image_id), INDEX IDX_B21FD430CA2A6A21 (sto_brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sto_product ADD CONSTRAINT FK_B21FD430B37A9F44 FOREIGN KEY (sto_image_id) REFERENCES sto_image (id)');
        $this->addSql('ALTER TABLE sto_product ADD CONSTRAINT FK_B21FD430CA2A6A21 FOREIGN KEY (sto_brand_id) REFERENCES sto_brand (id)');
        $this->addSql('ALTER TABLE sto_product_color ADD CONSTRAINT FK_5AC117F64584665A FOREIGN KEY (product_id) REFERENCES sto_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sto_product_color ADD CONSTRAINT FK_5AC117F67ADA1FB5 FOREIGN KEY (color_id) REFERENCES sto_color (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sto_product DROP FOREIGN KEY FK_B21FD430CA2A6A21');
        $this->addSql('ALTER TABLE sto_product_color DROP FOREIGN KEY FK_5AC117F67ADA1FB5');
        $this->addSql('ALTER TABLE sto_product DROP FOREIGN KEY FK_B21FD430B37A9F44');
        $this->addSql('ALTER TABLE sto_product_color DROP FOREIGN KEY FK_5AC117F64584665A');
        $this->addSql('DROP TABLE app_contact');
        $this->addSql('DROP TABLE sto_brand');
        $this->addSql('DROP TABLE sto_color');
        $this->addSql('DROP TABLE sto_image');
        $this->addSql('DROP TABLE sto_product');
    }
}
