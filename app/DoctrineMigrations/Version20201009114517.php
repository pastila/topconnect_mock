<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201009114517 extends AbstractMigration
{
  /**
   * @param Schema $schema
   */
  public function up (Schema $schema)
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE settings (name VARCHAR(50) NOT NULL, value LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E545A0C55E237E06 (name), PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
  }

  /**
   * @param Schema $schema
   */
  public function down (Schema $schema)
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('DROP TABLE settings');
  }
}
