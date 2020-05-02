<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502084647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_product_history (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_E4BF0774A76ED395 (user_id), INDEX IDX_E4BF07744584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, birth_date DATE DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, activity_level INT DEFAULT NULL, name VARCHAR(255) NOT NULL, weight_history LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', facebook_id VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_history LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', total_quantity_consummed DOUBLE PRECISION NOT NULL, details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE daily_food (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, kcal_target DOUBLE PRECISION DEFAULT NULL, kcal_consummed DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_903E3662A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE daily_food_product (daily_food_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_110993B3656F5630 (daily_food_id), INDEX IDX_110993B34584665A (product_id), PRIMARY KEY(daily_food_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pantry (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, total_kcal_in_stock DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_A26360CFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pantry_product (pantry_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_BB54DAC4DF44FAA (pantry_id), INDEX IDX_BB54DAC4584665A (product_id), PRIMARY KEY(pantry_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_product_history ADD CONSTRAINT FK_E4BF0774A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_product_history ADD CONSTRAINT FK_E4BF07744584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE daily_food ADD CONSTRAINT FK_903E3662A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE daily_food_product ADD CONSTRAINT FK_110993B3656F5630 FOREIGN KEY (daily_food_id) REFERENCES daily_food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE daily_food_product ADD CONSTRAINT FK_110993B34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pantry ADD CONSTRAINT FK_A26360CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pantry_product ADD CONSTRAINT FK_BB54DAC4DF44FAA FOREIGN KEY (pantry_id) REFERENCES pantry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pantry_product ADD CONSTRAINT FK_BB54DAC4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_product_history DROP FOREIGN KEY FK_E4BF0774A76ED395');
        $this->addSql('ALTER TABLE daily_food DROP FOREIGN KEY FK_903E3662A76ED395');
        $this->addSql('ALTER TABLE pantry DROP FOREIGN KEY FK_A26360CFA76ED395');
        $this->addSql('ALTER TABLE user_product_history DROP FOREIGN KEY FK_E4BF07744584665A');
        $this->addSql('ALTER TABLE daily_food_product DROP FOREIGN KEY FK_110993B34584665A');
        $this->addSql('ALTER TABLE pantry_product DROP FOREIGN KEY FK_BB54DAC4584665A');
        $this->addSql('ALTER TABLE daily_food_product DROP FOREIGN KEY FK_110993B3656F5630');
        $this->addSql('ALTER TABLE pantry_product DROP FOREIGN KEY FK_BB54DAC4DF44FAA');
        $this->addSql('DROP TABLE user_product_history');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE daily_food');
        $this->addSql('DROP TABLE daily_food_product');
        $this->addSql('DROP TABLE pantry');
        $this->addSql('DROP TABLE pantry_product');
    }
}
