<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211005173620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, img_cover VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, published_at DATE NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, is_reserved TINYINT(1) NOT NULL, is_favorite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_type (book_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_95431C2116A2B381 (book_id), INDEX IDX_95431C21C54C8C93 (type_id), PRIMARY KEY(book_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C2116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_type ADD CONSTRAINT FK_95431C21C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_type DROP FOREIGN KEY FK_95431C2116A2B381');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_type');
    }
}
