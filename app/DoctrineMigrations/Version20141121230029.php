<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141121230029 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Comment DROP FOREIGN KEY FK_5BC96BF04B89032C');
        $this->addSql('DROP INDEX IDX_5BC96BF04B89032C ON Comment');
        $this->addSql('ALTER TABLE Comment CHANGE post_id comment_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Comment ADD CONSTRAINT FK_5BC96BF0CA53B77D FOREIGN KEY (comment_object_id) REFERENCES Post (id)');
        $this->addSql('CREATE INDEX IDX_5BC96BF0CA53B77D ON Comment (comment_object_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Comment DROP FOREIGN KEY FK_5BC96BF0CA53B77D');
        $this->addSql('DROP INDEX IDX_5BC96BF0CA53B77D ON Comment');
        $this->addSql('ALTER TABLE Comment CHANGE comment_object_id post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Comment ADD CONSTRAINT FK_5BC96BF04B89032C FOREIGN KEY (post_id) REFERENCES Post (id)');
        $this->addSql('CREATE INDEX IDX_5BC96BF04B89032C ON Comment (post_id)');
    }
}
