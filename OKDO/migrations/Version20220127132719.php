<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127132719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B308530CC80CD12 FOREIGN KEY (age_id) REFERENCES age (id)');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B3085304296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_8B308530CC80CD12 ON profiles (age_id)');
        $this->addSql('CREATE INDEX IDX_8B3085304296D31F ON profiles (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B308530CC80CD12');
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B3085304296D31F');
        $this->addSql('DROP INDEX IDX_8B308530CC80CD12 ON profiles');
        $this->addSql('DROP INDEX IDX_8B3085304296D31F ON profiles');
    }
}
