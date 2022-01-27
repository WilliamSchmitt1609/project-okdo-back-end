<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127155758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE age (id INT AUTO_INCREMENT NOT NULL, age_range VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE age_profiles (age_id INT NOT NULL, profiles_id INT NOT NULL, INDEX IDX_C5FA7E79CC80CD12 (age_id), INDEX IDX_C5FA7E7922077C89 (profiles_id), PRIMARY KEY(age_id, profiles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE age_product (age_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_1D32194FCC80CD12 (age_id), INDEX IDX_1D32194F4584665A (product_id), PRIMARY KEY(age_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE age_profiles ADD CONSTRAINT FK_C5FA7E79CC80CD12 FOREIGN KEY (age_id) REFERENCES age (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE age_profiles ADD CONSTRAINT FK_C5FA7E7922077C89 FOREIGN KEY (profiles_id) REFERENCES profiles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE age_product ADD CONSTRAINT FK_1D32194FCC80CD12 FOREIGN KEY (age_id) REFERENCES age (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE age_product ADD CONSTRAINT FK_1D32194F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE age_profiles DROP FOREIGN KEY FK_C5FA7E79CC80CD12');
        $this->addSql('ALTER TABLE age_product DROP FOREIGN KEY FK_1D32194FCC80CD12');
        $this->addSql('DROP TABLE age');
        $this->addSql('DROP TABLE age_profiles');
        $this->addSql('DROP TABLE age_product');
    }
}
