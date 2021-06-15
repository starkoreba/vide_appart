<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614201148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, id_order_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_9CE58EE1DD4481AD (id_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line_product (order_line_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_622E11A0BB01DC09 (order_line_id), INDEX IDX_622E11A04584665A (product_id), PRIMARY KEY(order_line_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1DD4481AD FOREIGN KEY (id_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line_product ADD CONSTRAINT FK_622E11A0BB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_line_product ADD CONSTRAINT FK_622E11A04584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_line_product DROP FOREIGN KEY FK_622E11A0BB01DC09');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE order_line_product');
    }
}
