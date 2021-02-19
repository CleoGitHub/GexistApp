<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219072826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature (id INT AUTO_INCREMENT NOT NULL, subcategory_id INT NOT NULL, name VARCHAR(25) NOT NULL, INDEX IDX_1FD775665DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feature_value (id INT AUTO_INCREMENT NOT NULL, feature_id INT NOT NULL, value VARCHAR(25) NOT NULL, position INT NOT NULL, INDEX IDX_D429523D60E4B879 (feature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, subcategory_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, discount INT NOT NULL, is_new TINYINT(1) NOT NULL, INDEX IDX_1F1B251E5DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_feature_value (item_id INT NOT NULL, feature_value_id INT NOT NULL, INDEX IDX_3885FAE6126F525E (item_id), INDEX IDX_3885FAE680CD149D (feature_value_id), PRIMARY KEY(item_id, feature_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_color (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, color VARCHAR(25) NOT NULL, description LONGTEXT DEFAULT NULL, position INT NOT NULL, INDEX IDX_4CF15339126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_img (id INT AUTO_INCREMENT NOT NULL, item_color_id INT NOT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_5CD7B39E16D7D77E (item_color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcategory (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_DDCA44812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feature ADD CONSTRAINT FK_1FD775665DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE feature_value ADD CONSTRAINT FK_D429523D60E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE item_feature_value ADD CONSTRAINT FK_3885FAE6126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_feature_value ADD CONSTRAINT FK_3885FAE680CD149D FOREIGN KEY (feature_value_id) REFERENCES feature_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_color ADD CONSTRAINT FK_4CF15339126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_img ADD CONSTRAINT FK_5CD7B39E16D7D77E FOREIGN KEY (item_color_id) REFERENCES item_color (id)');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('ALTER TABLE feature_value DROP FOREIGN KEY FK_D429523D60E4B879');
        $this->addSql('ALTER TABLE item_feature_value DROP FOREIGN KEY FK_3885FAE680CD149D');
        $this->addSql('ALTER TABLE item_feature_value DROP FOREIGN KEY FK_3885FAE6126F525E');
        $this->addSql('ALTER TABLE item_color DROP FOREIGN KEY FK_4CF15339126F525E');
        $this->addSql('ALTER TABLE item_img DROP FOREIGN KEY FK_5CD7B39E16D7D77E');
        $this->addSql('ALTER TABLE feature DROP FOREIGN KEY FK_1FD775665DC6FE57');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5DC6FE57');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE feature');
        $this->addSql('DROP TABLE feature_value');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_feature_value');
        $this->addSql('DROP TABLE item_color');
        $this->addSql('DROP TABLE item_img');
        $this->addSql('DROP TABLE subcategory');
    }
}
