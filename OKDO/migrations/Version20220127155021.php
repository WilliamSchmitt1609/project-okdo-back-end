<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127155021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, number INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_product (event_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_561DAD0271F7E88B (event_id), INDEX IDX_561DAD024584665A (product_id), PRIMARY KEY(event_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_product ADD CONSTRAINT FK_561DAD0271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_product ADD CONSTRAINT FK_561DAD024584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profiles ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profiles ADD CONSTRAINT FK_8B30853071F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_8B30853071F7E88B ON profiles (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_product DROP FOREIGN KEY FK_561DAD0271F7E88B');
        $this->addSql('ALTER TABLE profiles DROP FOREIGN KEY FK_8B30853071F7E88B');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_product');
        $this->addSql('DROP INDEX IDX_8B30853071F7E88B ON profiles');
        $this->addSql('ALTER TABLE profiles DROP event_id');
    }
}
