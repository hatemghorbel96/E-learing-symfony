<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612170100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat_course ADD course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etat_course ADD CONSTRAINT FK_A465F3BD591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_A465F3BD591CC992 ON etat_course (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat_course DROP FOREIGN KEY FK_A465F3BD591CC992');
        $this->addSql('DROP INDEX IDX_A465F3BD591CC992 ON etat_course');
        $this->addSql('ALTER TABLE etat_course DROP course_id');
    }
}
