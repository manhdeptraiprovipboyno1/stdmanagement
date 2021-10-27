<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026160907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_m_lecturer (class_m_id INT NOT NULL, lecturer_id INT NOT NULL, INDEX IDX_AD98159CC575DBAF (class_m_id), INDEX IDX_AD98159CBA2D8762 (lecturer_id), PRIMARY KEY(class_m_id, lecturer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_m_lecturer ADD CONSTRAINT FK_AD98159CC575DBAF FOREIGN KEY (class_m_id) REFERENCES class_m (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_m_lecturer ADD CONSTRAINT FK_AD98159CBA2D8762 FOREIGN KEY (lecturer_id) REFERENCES lecturer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE class_m_lecturer');
    }
}
