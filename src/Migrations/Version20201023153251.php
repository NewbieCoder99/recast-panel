<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023153251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE streams (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, live TINYINT(1) DEFAULT \'0\' NOT NULL, stream_key VARCHAR(255) NOT NULL, INDEX IDX_FFF7AFAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, role VARCHAR(255) DEFAULT \'user\' NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE endpoint (id INT AUTO_INCREMENT NOT NULL, stream_id INT DEFAULT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, server VARCHAR(255) NOT NULL, streamKey VARCHAR(255) NOT NULL, INDEX IDX_C4420F7BD0ED463E (stream_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE queue (id INT AUTO_INCREMENT NOT NULL, task VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE streams ADD CONSTRAINT FK_FFF7AFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE endpoint ADD CONSTRAINT FK_C4420F7BD0ED463E FOREIGN KEY (stream_id) REFERENCES streams (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE endpoint DROP FOREIGN KEY FK_C4420F7BD0ED463E');
        $this->addSql('ALTER TABLE streams DROP FOREIGN KEY FK_FFF7AFAA76ED395');
        $this->addSql('DROP TABLE streams');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE endpoint');
        $this->addSql('DROP TABLE queue');
    }
}
