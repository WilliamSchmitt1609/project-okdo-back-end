<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127154147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filter_type_category DROP FOREIGN KEY FK_A529953A72DCFBF6');
        $this->addSql('DROP TABLE filter_type');
        $this->addSql('DROP TABLE filter_type_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filter_type (id INT AUTO_INCREMENT NOT NULL, event_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, event_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE filter_type_category (filter_type_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_A529953A12469DE2 (category_id), INDEX IDX_A529953A72DCFBF6 (filter_type_id), PRIMARY KEY(filter_type_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE filter_type_category ADD CONSTRAINT FK_A529953A72DCFBF6 FOREIGN KEY (filter_type_id) REFERENCES filter_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filter_type_category ADD CONSTRAINT FK_A529953A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }
}
