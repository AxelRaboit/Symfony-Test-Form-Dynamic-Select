<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120143203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_12AD233EF92F3E70 (country_id), INDEX IDX_12AD233E8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233EF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233EF92F3E70');
        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E8BAC62AF');
        $this->addSql('DROP TABLE issue');
    }
}
