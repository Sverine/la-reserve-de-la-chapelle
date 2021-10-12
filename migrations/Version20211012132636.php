<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012132636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, img_cover VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, published_at DATE NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, is_reserved TINYINT(1) NOT NULL, is_favorite TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_type (book_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_95431C2116A2B381 (book_id), INDEX IDX_95431C21C54C8C93 (type_id), PRIMARY KEY(book_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_loan (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, user_id INT NOT NULL, date_loan DATETIME DEFAULT NULL, date_return DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, date_reserved DATETIME NOT NULL, is_late TINYINT(1) NOT NULL, INDEX IDX_DC4E460B16A2B381 (book_id), INDEX IDX_DC4E460BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(100) NOT NULL, date_birth DATE NOT NULL, address LONGTEXT NOT NULL, is_confirmed TINYINT(1) NOT NULL, date_inscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C2116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C21C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_loan ADD CONSTRAINT FK_DC4E460B16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_loan ADD CONSTRAINT FK_DC4E460BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_type DROP FOREIGN KEY FK_95431C2116A2B381');
        $this->addSql('ALTER TABLE book_loan DROP FOREIGN KEY FK_DC4E460B16A2B381');
        $this->addSql('ALTER TABLE book_type DROP FOREIGN KEY FK_95431C21C54C8C93');
        $this->addSql('ALTER TABLE book_loan DROP FOREIGN KEY FK_DC4E460BA76ED395');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_type');
        $this->addSql('DROP TABLE book_loan');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
