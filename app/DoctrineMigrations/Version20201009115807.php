<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201009115807 extends AbstractMigration
{
  /**
   * @param Schema $schema
   */
  public function up (Schema $schema)
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('DELETE FROM cards');
    $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, card_id INT NOT NULL, order_id INT NOT NULL, available_amount VARCHAR(50) DEFAULT NULL, amount NUMERIC(18, 2) NOT NULL, currency VARCHAR(5) NOT NULL, INDEX IDX_EAA81A4C4ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE accounts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, api_login VARCHAR(50) NOT NULL, api_password VARCHAR(50) NOT NULL, active_at DATETIME DEFAULT NULL, expire_at DATETIME DEFAULT NULL, balance NUMERIC(18, 2) NOT NULL, currency VARCHAR(5) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CAC89EAC8E9D9FC0 (api_login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C4ACC9A20 FOREIGN KEY (card_id) REFERENCES cards (id) ON DELETE CASCADE');
    $this->addSql('ALTER TABLE cards ADD account_id INT NOT NULL');
    $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FD9B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id)');
    $this->addSql('CREATE INDEX IDX_4C258FD9B6B5FBA ON cards (account_id)');
  }

  /**
   * @param Schema $schema
   */
  public function down (Schema $schema)
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FD9B6B5FBA');
    $this->addSql('DROP TABLE transactions');
    $this->addSql('DROP TABLE accounts');
    $this->addSql('DROP INDEX IDX_4C258FD9B6B5FBA ON cards');
    $this->addSql('ALTER TABLE cards DROP account_id');
  }
}
