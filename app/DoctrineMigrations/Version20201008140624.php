<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201008140624 extends AbstractMigration
{
  /**
   * @param Schema $schema
   */
  public function up (Schema $schema)
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE card_services (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE cards (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, i_num VARCHAR(50) NOT NULL, msisdn VARCHAR(50) NOT NULL, prepayed TINYINT(1) DEFAULT \'0\' NOT NULL, balance NUMERIC(18, 2) DEFAULT \'0\' NOT NULL, currency VARCHAR(5) NOT NULL, iccid VARCHAR(50) NOT NULL, primary_number VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, last_usage_at DATETIME DEFAULT NULL, first_usage_at DATETIME DEFAULT NULL, overdraft NUMERIC(18, 2) NOT NULL, blocked TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_4C258FDED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE secondary_numbers (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, number VARCHAR(50) NOT NULL, INDEX IDX_B2803C394ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FDED5CA9E6 FOREIGN KEY (service_id) REFERENCES card_services (id)');
    $this->addSql('ALTER TABLE secondary_numbers ADD CONSTRAINT FK_B2803C394ACC9A20 FOREIGN KEY (card_id) REFERENCES cards (id)');
  }

  /**
   * @param Schema $schema
   */
  public function down (Schema $schema)
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FDED5CA9E6');
    $this->addSql('ALTER TABLE secondary_numbers DROP FOREIGN KEY FK_B2803C394ACC9A20');
    $this->addSql('DROP TABLE card_services');
    $this->addSql('DROP TABLE cards');
    $this->addSql('DROP TABLE secondary_numbers');
  }
}
