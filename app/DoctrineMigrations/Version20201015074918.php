<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201015074918 extends AbstractMigration
{
  /**
   * @param Schema $schema
   */
  public function up (Schema $schema)
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE call_records (id INT NOT NULL, duration INT NOT NULL, c_cost NUMERIC(18, 2) NOT NULL, uniq_id VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE records (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, direction VARCHAR(20) NOT NULL, second_phone_number VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, `type` VARCHAR(20) NOT NULL, INDEX IDX_9C9D58464ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE sms_records (id INT NOT NULL, text VARCHAR(160) DEFAULT NULL, sms_cost NUMERIC(18, 2) NOT NULL, part INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE call_records ADD CONSTRAINT FK_4938C173BF396750 FOREIGN KEY (id) REFERENCES records (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE records ADD CONSTRAINT FK_9C9D58464ACC9A20 FOREIGN KEY (card_id) REFERENCES cards (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE sms_records ADD CONSTRAINT FK_6C87939CBF396750 FOREIGN KEY (id) REFERENCES records (id) ON DELETE CASCADE');
  }

  /**
   * @param Schema $schema
   */
  public function down (Schema $schema)
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE call_records DROP FOREIGN KEY FK_4938C173BF396750');
    $this->addSql('ALTER TABLE sms_records DROP FOREIGN KEY FK_6C87939CBF396750');
    $this->addSql('DROP TABLE call_records');
    $this->addSql('DROP TABLE records');
    $this->addSql('DROP TABLE sms_records');
  }
}
