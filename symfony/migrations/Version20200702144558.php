<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200702144558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD liv_adress_id INT DEFAULT NULL, CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912C1DBC9 FOREIGN KEY (liv_adress_id) REFERENCES liv_adress (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64912C1DBC9 ON user (liv_adress_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912C1DBC9');
        $this->addSql('DROP INDEX IDX_8D93D64912C1DBC9 ON user');
        $this->addSql('ALTER TABLE user DROP liv_adress_id, CHANGE role_id role_id INT NOT NULL');
    }
}
