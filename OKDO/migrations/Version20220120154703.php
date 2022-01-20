<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120154703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_profiles (category_id INT NOT NULL, profiles_id INT NOT NULL, INDEX IDX_3C4A014B12469DE2 (category_id), INDEX IDX_3C4A014B22077C89 (profiles_id), PRIMARY KEY(category_id, profiles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_profiles ADD CONSTRAINT FK_3C4A014B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_profiles ADD CONSTRAINT FK_3C4A014B22077C89 FOREIGN KEY (profiles_id) REFERENCES profiles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_profiles');
    }
}
