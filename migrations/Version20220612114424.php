<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612114424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB943DB87C9');
        $this->addSql('DROP INDEX IDX_169E6FB943DB87C9 ON course');
        $this->addSql('ALTER TABLE course DROP progress_id');
        $this->addSql('ALTER TABLE progress ADD course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_2201F246591CC992 ON progress (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD progress_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB943DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB943DB87C9 ON course (progress_id)');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246591CC992');
        $this->addSql('DROP INDEX IDX_2201F246591CC992 ON progress');
        $this->addSql('ALTER TABLE progress DROP course_id');
    }
}
