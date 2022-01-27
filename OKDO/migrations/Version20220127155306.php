<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127155306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADCC80CD12');
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530CC80CD12');
        $this->addSql('DROP TABLE age');
        $this->addSql('DROP INDEX IDX_D34A04ADCC80CD12 ON product');
        $this->addSql('ALTER TABLE product DROP age_id');
        $this->addSql('DROP INDEX IDX_8B308530CC80CD12 ON profiles');
        $this->addSql('ALTER TABLE profiles DROP age_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE age (id INT AUTO_INCREMENT NOT NULL, age_range VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product ADD age_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADCC80CD12 FOREIGN KEY (age_id) REFERENCES age (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADCC80CD12 ON product (age_id)');
        $this->addSql('ALTER TABLE profiles ADD age_id INT NOT NULL');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530CC80CD12 FOREIGN KEY (age_id) REFERENCES age (id)');
        $this->addSql('CREATE INDEX IDX_8B308530CC80CD12 ON profiles (age_id)');
    }
}
