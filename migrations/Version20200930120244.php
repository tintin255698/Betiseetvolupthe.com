<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930120244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_composant (id INT AUTO_INCREMENT NOT NULL, commande_menu_id INT NOT NULL, produit VARCHAR(255) NOT NULL, quantite INT NOT NULL, INDEX IDX_FC88DC8B3A6C9BB2 (commande_menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_menu (id INT AUTO_INCREMENT NOT NULL, produit VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_composant ADD CONSTRAINT FK_FC88DC8B3A6C9BB2 FOREIGN KEY (commande_menu_id) REFERENCES commande_menu (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_composant DROP FOREIGN KEY FK_FC88DC8B3A6C9BB2');
        $this->addSql('DROP TABLE commande_composant');
        $this->addSql('DROP TABLE commande_menu');
    }
}
