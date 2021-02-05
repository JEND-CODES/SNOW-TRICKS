<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205005437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classification (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, author VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E20259CD5C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screen (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, thumbnail LONGTEXT DEFAULT NULL, INDEX IDX_DF4C61305C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CD5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61305C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE figure ADD classification_id INT NOT NULL, ADD image_one LONGTEXT DEFAULT NULL, ADD image_two LONGTEXT DEFAULT NULL, ADD image_three LONGTEXT DEFAULT NULL, ADD video_one LONGTEXT DEFAULT NULL, ADD video_two LONGTEXT DEFAULT NULL, ADD video_three LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A2A86559F FOREIGN KEY (classification_id) REFERENCES classification (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A2A86559F ON figure (classification_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A2A86559F');
        $this->addSql('DROP TABLE classification');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE screen');
        $this->addSql('DROP INDEX IDX_2F57B37A2A86559F ON figure');
        $this->addSql('ALTER TABLE figure DROP classification_id, DROP image_one, DROP image_two, DROP image_three, DROP video_one, DROP video_two, DROP video_three');
    }
}
