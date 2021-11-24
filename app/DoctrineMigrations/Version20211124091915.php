<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124091915 extends AbstractMigration
{
  public function up (Schema $schema): void
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//    $this->addSql('CREATE TABLE data_package_records (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, package_id INT DEFAULT NULL, msisdn VARCHAR(255) DEFAULT NULL, activated_at DATETIME DEFAULT NULL, expire_at DATETIME DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, balance_before DOUBLE PRECISION DEFAULT NULL, balance_after DOUBLE PRECISION DEFAULT NULL, disabled TINYINT(1) DEFAULT \'0\' NOT NULL, timeframes INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6677D4DD4ACC9A20 (card_id), INDEX IDX_6677D4DDF44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
//    $this->addSql('CREATE TABLE data_packages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, code INT NOT NULL, period INT NOT NULL, volume DOUBLE PRECISION NOT NULL, activation_fee DOUBLE PRECISION NOT NULL, order_fee DOUBLE PRECISION NOT NULL, currency VARCHAR(3) NOT NULL, activation_type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
//    $this->addSql('ALTER TABLE data_package_records ADD CONSTRAINT FK_6677D4DD4ACC9A20 FOREIGN KEY (card_id) REFERENCES cards (id) ON DELETE CASCADE');
//    $this->addSql('ALTER TABLE data_package_records ADD CONSTRAINT FK_6677D4DDF44CABFF FOREIGN KEY (package_id) REFERENCES data_packages (id) ON DELETE CASCADE');
    $data = [
      [
        ':name' => 'Data 10Mb Zone B',
        ':code' => 1,
        ':period' => 1,
        ':volume' => 10,
        ':fee' => 1,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 50Mb Zone B',
        ':code' => 2,
        ':period' => 1,
        ':volume' => 50,
        ':fee' => 5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 150Mb Zone B',
        ':code' => 3,
        ':period' => 7,
        ':volume' => 150,
        ':fee' => 10,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 250Mb Zone B',
        ':code' => 4,
        ':period' => 14,
        ':volume' => 250,
        ':fee' => 19,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 500Mb Zone B',
        ':code' => 5,
        ':period' => 30,
        ':volume' => 500,
        ':fee' => 35,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Daily Auto 10Mb Zone B',
        ':code' => 7,
        ':period' => 1,
        ':volume' => 10,
        ':fee' => 0.75,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'auto',
      ],
      [
        ':name' => 'Data 2000Mb Zone B',
        ':code' => 8,
        ':period' => 30,
        ':volume' => 2000,
        ':fee' => 89,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 1000Mb Zone B',
        ':code' => 9,
        ':period' => 30,
        ':volume' => 1000,
        ':fee' => 55,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 1000Mb Zone A',
        ':code' => 11,
        ':period' => 30,
        ':volume' => 1000,
        ':fee' => 18,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Special Data package 5000Mb',
        ':code' => 12,
        ':period' => 30,
        ':volume' => 5000,
        ':fee' => 26,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 10Mb Zone A',
        ':code' => 13,
        ':period' => 1,
        ':volume' => 10,
        ':fee' => 0.5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 50Mb Zone A',
        ':code' => 14,
        ':period' => 1,
        ':volume' => 50,
        ':fee' => 2.5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 150Mb Zone A',
        ':code' => 15,
        ':period' => 7,
        ':volume' => 150,
        ':fee' => 5.5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 250Mb Zone A',
        ':code' => 16,
        ':period' => 14,
        ':volume' => 250,
        ':fee' => 8,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 500Mb Zone A',
        ':code' => 17,
        ':period' => 30,
        ':volume' => 500,
        ':fee' => 12,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Daily Auto 10Mb Zone A',
        ':code' => 20,
        ':period' => 1,
        ':volume' => 10,
        ':fee' => 0.5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 2000Mb Zone A',
        ':code' => 40,
        ':period' => 30,
        ':volume' => 2000,
        ':fee' => 34,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe PLUS Data Package AUTO',
        ':code' => 48,
        ':period' => 365,
        ':volume' => 0,
        ':fee' => 0,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'auto',
      ],
      [
        ':name' => 'Special Data package 1000Mb',
        ':code' => 50,
        ':period' => 14,
        ':volume' => 1000,
        ':fee' => 5,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Turkey Data Package',
        ':code' => 51,
        ':period' => 14,
        ':volume' => 1000,
        ':fee' => 14,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 5000MB',
        ':code' => 52,
        ':period' => 30,
        ':volume' => 5000,
        ':fee' => 39,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 3000Mb Zone A',
        ':code' => 63,
        ':period' => 30,
        ':volume' => 3000,
        ':fee' => 49,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 5000Mb Zone A',
        ':code' => 64,
        ':period' => 30,
        ':volume' => 5000,
        ':fee' => 79,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 3000Mb Zone B',
        ':code' => 67,
        ':period' => 30,
        ':volume' => 3000,
        ':fee' => 120,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Data 5000Mb Zone B',
        ':code' => 68,
        ':period' => 30,
        ':volume' => 5000,
        ':fee' => 145,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 1000MB',
        ':code' => 75,
        ':period' => 30,
        ':volume' => 1000,
        ':fee' => 8.9,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 100MB AUTO',
        ':code' => 76,
        ':period' => 1,
        ':volume' => 100,
        ':fee' => 0.9,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'auto',
      ],
      [
        ':name' => 'Europe Data Package 5000MB',
        ':code' => 77,
        ':period' => 14,
        ':volume' => 5000,
        ':fee' => 25,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Data Package 10000MB',
        ':code' => 78,
        ':period' => 14,
        ':volume' => 10000,
        ':fee' => 49,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 500MB AUTO',
        ':code' => 92,
        ':period' => 1,
        ':volume' => 500,
        ':fee' => 3.9,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 2000MB',
        ':code' => 93,
        ':period' => 30,
        ':volume' => 2000,
        ':fee' => 16.9,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
      [
        ':name' => 'Europe Extra Data Package 10000MB',
        ':code' => 94,
        ':period' => 30,
        ':volume' => 10000,
        ':fee' => 72.9,
        ':order_fee' => 0,
        ':cur' => 'EUR',
        ':type' => 'order',
      ],
    ];

    foreach ($data as $datum)
    {
      $this->addSql('INSERT INTO data_packages (name, code, period, volume, activation_fee, order_fee, currency, activation_type) VALUES (:name, :code, :period, :volume, :fee, :order_fee, :cur, :type)', $datum);
    }
  }

  public function down (Schema $schema): void
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE data_package_records DROP FOREIGN KEY FK_6677D4DDF44CABFF');
    $this->addSql('DROP TABLE data_package_records');
    $this->addSql('DROP TABLE data_packages');
  }
}
