<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620075926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ingredient_menu (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, INDEX IDX_23548A05933FE08C (ingredient_id), INDEX IDX_23548A05CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredient_menu ADD CONSTRAINT FK_23548A05933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE ingredient_menu ADD CONSTRAINT FK_23548A05CCD7E912 FOREIGN KEY (menu_id) REFERENCES booking (id)');
        $this->addSql('DROP TABLE ingredient_booking');
        $this->addSql('ALTER TABLE ingredient DROP quantity');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ingredient_booking (ingredient_id INT NOT NULL, booking_id INT NOT NULL, INDEX IDX_E13BE6183301C60 (booking_id), INDEX IDX_E13BE618933FE08C (ingredient_id), PRIMARY KEY(ingredient_id, booking_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ingredient_booking ADD CONSTRAINT FK_E13BE6183301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ingredient_booking ADD CONSTRAINT FK_E13BE618933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ingredient_menu');
        $this->addSql('ALTER TABLE ingredient ADD quantity NUMERIC(10, 0) DEFAULT NULL');
    }
}
