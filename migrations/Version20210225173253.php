<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225173253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classification (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(80) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE figure (id INT AUTO_INCREMENT NOT NULL, classification_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(80) NOT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, fresh_date DATETIME DEFAULT NULL, labelled VARCHAR(80) DEFAULT NULL, UNIQUE INDEX UNIQ_2F57B37A2B36786B (title), INDEX IDX_2F57B37A2A86559F (classification_id), INDEX IDX_2F57B37AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(80) NOT NULL, username VARCHAR(80) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, password VARCHAR(80) NOT NULL, newpass VARCHAR(80) DEFAULT NULL, created_at DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, validation TINYINT(1) NOT NULL, status INT DEFAULT NULL, UNIQUE INDEX UNIQ_70E4FA78E7927C74 (email), UNIQUE INDEX UNIQ_70E4FA78F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mention (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, user_id INT NOT NULL, author VARCHAR(80) DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E20259CD5C011B5 (figure_id), INDEX IDX_E20259CDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screen (id INT AUTO_INCREMENT NOT NULL, figure_id INT NOT NULL, thumbnail LONGTEXT DEFAULT NULL, INDEX IDX_DF4C61305C011B5 (figure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A2A86559F FOREIGN KEY (classification_id) REFERENCES classification (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AA76ED395 FOREIGN KEY (user_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CD5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE mention ADD CONSTRAINT FK_E20259CDA76ED395 FOREIGN KEY (user_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61305C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A2A86559F');
        $this->addSql('ALTER TABLE mention DROP FOREIGN KEY FK_E20259CD5C011B5');
        $this->addSql('ALTER TABLE screen DROP FOREIGN KEY FK_DF4C61305C011B5');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AA76ED395');
        $this->addSql('ALTER TABLE mention DROP FOREIGN KEY FK_E20259CDA76ED395');
        $this->addSql('DROP TABLE classification');
        $this->addSql('DROP TABLE figure');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE mention');
        $this->addSql('DROP TABLE screen');
    }
}
