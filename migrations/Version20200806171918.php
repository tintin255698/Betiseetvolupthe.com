<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806171918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, societe VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, INDEX IDX_C35F0816A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, note INT NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eau (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_EDD40F8C1D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jus (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_21453AD11D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, INDEX IDX_7D053A931D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picnic (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, INDEX IDX_259CE7951D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repas (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_A8D351B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(15) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, personne INT NOT NULL, message VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE the (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_3C456DE61D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, password_requested_at DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vin (id INT AUTO_INCREMENT NOT NULL, repas_id INT DEFAULT NULL, produit LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_B10851411D236AAA (repas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eau ADD CONSTRAINT FK_EDD40F8C1D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE jus ADD CONSTRAINT FK_21453AD11D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A931D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE picnic ADD CONSTRAINT FK_259CE7951D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE repas ADD CONSTRAINT FK_A8D351B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE the ADD CONSTRAINT FK_3C456DE61D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
        $this->addSql('ALTER TABLE vin ADD CONSTRAINT FK_B10851411D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eau DROP FOREIGN KEY FK_EDD40F8C1D236AAA');
        $this->addSql('ALTER TABLE jus DROP FOREIGN KEY FK_21453AD11D236AAA');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A931D236AAA');
        $this->addSql('ALTER TABLE picnic DROP FOREIGN KEY FK_259CE7951D236AAA');
        $this->addSql('ALTER TABLE the DROP FOREIGN KEY FK_3C456DE61D236AAA');
        $this->addSql('ALTER TABLE vin DROP FOREIGN KEY FK_B10851411D236AAA');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE repas DROP FOREIGN KEY FK_A8D351B3A76ED395');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE eau');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE jus');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE picnic');
        $this->addSql('DROP TABLE repas');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE the');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vin');
    }
}
