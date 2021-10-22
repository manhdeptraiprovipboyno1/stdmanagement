<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022110700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_m (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, floor INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecturer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, nationality VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, class_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, nationality VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, INDEX IDX_B723AF33F8DB7177 (class_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, lecturer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, abbre INT NOT NULL, INDEX IDX_FBCE3E7ABA2D8762 (lecturer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33F8DB7177 FOREIGN KEY (class_list_id) REFERENCES class_m (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7ABA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33F8DB7177');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7ABA2D8762');
        $this->addSql('DROP TABLE class_m');
        $this->addSql('DROP TABLE lecturer');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
    }
}
