<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207121621 extends AbstractMigration
{
  public function up (Schema $schema)
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE data_records (id INT NOT NULL, operator_code VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, operator VARCHAR(50) DEFAULT NULL, ip_address VARCHAR(50) DEFAULT NULL, sessionid VARCHAR(50) DEFAULT NULL, in_bytes INT DEFAULT NULL, out_bytes INT DEFAULT NULL, rate DOUBLE PRECISION DEFAULT NULL, cost DOUBLE PRECISION DEFAULT NULL, quosid VARCHAR(50) DEFAULT NULL, rg INT DEFAULT NULL, end_at DATETIME DEFAULT NULL, usage_bytes INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    $this->addSql('ALTER TABLE data_records ADD CONSTRAINT FK_F8960EB7BF396750 FOREIGN KEY (id) REFERENCES records (id) ON DELETE CASCADE');
    $this->addSql('DROP INDEX UNIQ_E545A0C55E237E06 ON settings');
  }

  public function down (Schema $schema)
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('DROP TABLE data_records');
    $this->addSql('CREATE UNIQUE INDEX UNIQ_E545A0C55E237E06 ON settings (name)');
  }
}
