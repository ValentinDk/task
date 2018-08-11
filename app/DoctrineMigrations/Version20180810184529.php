<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180810184529 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tblproductdata ADD stock INT NOT NULL, ADD cost DOUBLE PRECISION NOT NULL, CHANGE intProductDataId intProductDataId INT AUTO_INCREMENT NOT NULL, CHANGE strProductName strProductName VARCHAR(255) NOT NULL, CHANGE strProductCode strProductCode VARCHAR(255) NOT NULL, CHANGE dtmAdded dtmAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('DROP INDEX strproductcode ON tblproductdata');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ABF046F62F10A58 ON tblproductdata (strProductCode)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tblproductdata DROP stock, DROP cost, CHANGE intProductDataId intProductDataId INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE strProductCode strProductCode VARCHAR(10) NOT NULL COLLATE latin1_swedish_ci, CHANGE strProductName strProductName VARCHAR(50) NOT NULL COLLATE latin1_swedish_ci, CHANGE dtmAdded dtmAdded DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_abf046f62f10a58 ON tblproductdata');
        $this->addSql('CREATE UNIQUE INDEX strProductCode ON tblproductdata (strProductCode)');
    }
}
