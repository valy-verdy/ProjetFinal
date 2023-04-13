<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411134201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_blog (id INT AUTO_INCREMENT NOT NULL, category_blog_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, post_date DATETIME NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_7057D6421D383EE9 (category_blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_blog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_blog (id INT AUTO_INCREMENT NOT NULL, article_blog_id INT DEFAULT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_322FBBDD37323A20 (article_blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_blog ADD CONSTRAINT FK_7057D6421D383EE9 FOREIGN KEY (category_blog_id) REFERENCES category_blog (id)');
        $this->addSql('ALTER TABLE image_blog ADD CONSTRAINT FK_322FBBDD37323A20 FOREIGN KEY (article_blog_id) REFERENCES article_blog (id)');
        $this->addSql('ALTER TABLE category ADD cat_premier_id INT DEFAULT NULL, DROP description, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C142017C2C FOREIGN KEY (cat_premier_id) REFERENCES cat_premier (id)');
        $this->addSql('CREATE INDEX IDX_64C19C142017C2C ON category (cat_premier_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DC2902E0');
        $this->addSql('DROP INDEX IDX_F5299398DC2902E0 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP client_id_id, CHANGE ref_order ref_order VARCHAR(255) NOT NULL, CHANGE amount amount DOUBLE PRECISION NOT NULL, CHANGE order_date order_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1F91A0F34');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1FCDAEAAA');
        $this->addSql('DROP INDEX UNIQ_9CE58EE1F91A0F34 ON order_line');
        $this->addSql('DROP INDEX IDX_9CE58EE1FCDAEAAA ON order_line');
        $this->addSql('ALTER TABLE order_line ADD orders_id INT DEFAULT NULL, ADD quantity INT NOT NULL, DROP order_id_id, DROP prod_id_id, DROP quantite');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE1CFFE9AD6 ON order_line (orders_id)');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user ADD phone VARCHAR(255) NOT NULL, ADD adress VARCHAR(255) NOT NULL, ADD post_code INT NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD gender VARCHAR(15) NOT NULL, CHANGE name lastname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog DROP FOREIGN KEY FK_7057D6421D383EE9');
        $this->addSql('ALTER TABLE image_blog DROP FOREIGN KEY FK_322FBBDD37323A20');
        $this->addSql('DROP TABLE article_blog');
        $this->addSql('DROP TABLE category_blog');
        $this->addSql('DROP TABLE image_blog');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C142017C2C');
        $this->addSql('DROP INDEX IDX_64C19C142017C2C ON category');
        $this->addSql('ALTER TABLE category ADD description VARCHAR(255) NOT NULL, DROP cat_premier_id, CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD client_id_id INT NOT NULL, CHANGE ref_order ref_order VARCHAR(60) NOT NULL, CHANGE amount amount VARCHAR(255) NOT NULL, CHANGE order_date order_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DC2902E0 FOREIGN KEY (client_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398DC2902E0 ON `order` (client_id_id)');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1CFFE9AD6');
        $this->addSql('DROP INDEX IDX_9CE58EE1CFFE9AD6 ON order_line');
        $this->addSql('ALTER TABLE order_line ADD prod_id_id INT NOT NULL, ADD quantite INT NOT NULL, DROP orders_id, CHANGE quantity order_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1F91A0F34 FOREIGN KEY (prod_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9CE58EE1F91A0F34 ON order_line (prod_id_id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE1FCDAEAAA ON order_line (order_id_id)');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT NOT NULL, CHANGE name name VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, DROP lastname, DROP phone, DROP adress, DROP post_code, DROP city, DROP gender');
    }
}
