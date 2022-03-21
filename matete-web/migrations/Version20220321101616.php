<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321101616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, producteur_id INT DEFAULT NULL, status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_32EB52E8AB9BB300 (producteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, lieu_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, producteur_id INT DEFAULT NULL, creneaux_debut DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', creneaux_fin DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', libelle_produit VARCHAR(50) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, status VARCHAR(50) NOT NULL, date_mise_en_ligne DATETIME DEFAULT NULL, INDEX IDX_F65593E56AB213CC (lieu_id), INDEX IDX_F65593E5BCF5E72D (categorie_id), INDEX IDX_F65593E5AB9BB300 (producteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, date_commande DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_annonce (commande_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_EEE14582EA2E54 (commande_id), INDEX IDX_EEE1458805AB2F (annonce_id), PRIMARY KEY(commande_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, coo_x VARCHAR(255) NOT NULL, coo_y VARCHAR(255) NOT NULL, desc_lieu VARCHAR(255) DEFAULT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu_producteur (lieu_id INT NOT NULL, producteur_id INT NOT NULL, INDEX IDX_2BB1AFA46AB213CC (lieu_id), INDEX IDX_2BB1AFA4AB9BB300 (producteur_id), PRIMARY KEY(lieu_id, producteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, tel VARCHAR(16) NOT NULL, mail VARCHAR(50) NOT NULL, mdp VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_1483A5E95126AC48 (mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8AB9BB300 FOREIGN KEY (producteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5AB9BB300 FOREIGN KEY (producteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commande_annonce ADD CONSTRAINT FK_EEE14582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_annonce ADD CONSTRAINT FK_EEE1458805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lieu_producteur ADD CONSTRAINT FK_2BB1AFA46AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lieu_producteur ADD CONSTRAINT FK_2BB1AFA4AB9BB300 FOREIGN KEY (producteur_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_annonce DROP FOREIGN KEY FK_EEE1458805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('ALTER TABLE commande_annonce DROP FOREIGN KEY FK_EEE14582EA2E54');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56AB213CC');
        $this->addSql('ALTER TABLE lieu_producteur DROP FOREIGN KEY FK_2BB1AFA46AB213CC');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8AB9BB300');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5AB9BB300');
        $this->addSql('ALTER TABLE lieu_producteur DROP FOREIGN KEY FK_2BB1AFA4AB9BB300');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_annonce');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE lieu_producteur');
        $this->addSql('DROP TABLE users');
    }
}
