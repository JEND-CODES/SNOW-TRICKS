<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210206215010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A2A86559F FOREIGN KEY (classification_id) REFERENCES classification (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A2A86559F ON figure (classification_id)');
        $this->addSql('ALTER TABLE member ADD created_at DATETIME DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD validation TINYINT(1) NOT NULL, ADD status INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A2A86559F');
        $this->addSql('DROP INDEX IDX_2F57B37A2A86559F ON figure');
        $this->addSql('ALTER TABLE member DROP created_at, DROP token, DROP validation, DROP status');
    }
}
