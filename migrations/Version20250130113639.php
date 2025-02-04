<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130113639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, image LONGTEXT DEFAULT NULL, libelle VARCHAR(254) NOT NULL, description VARCHAR(254) DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY blog_ibfk_1');
        $this->addSql('ALTER TABLE blog CHANGE utilisateurId utilisateurId INT NOT NULL, CHANGE libelle libelle VARCHAR(254) NOT NULL, CHANGE description description TINYTEXT DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514331EE9377 FOREIGN KEY (utilisateurId) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE blog RENAME INDEX utilisateurid TO IDX_C015514331EE9377');
        $this->addSql('ALTER TABLE blog_commentaire CHANGE commentaire commentaire LONGTEXT DEFAULT NULL, CHANGE nom nom LONGTEXT DEFAULT NULL, CHANGE email email LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE blog_commentaire RENAME INDEX blogid TO IDX_BEC0F442ED85FE43');
        $this->addSql('ALTER TABLE competence CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle LONGTEXT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contactez_nous CHANGE email email VARCHAR(255) NOT NULL, CHANGE tel tel VARCHAR(20) NOT NULL, CHANGE objet objet VARCHAR(255) NOT NULL, CHANGE message message LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE personneId personneId INT DEFAULT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX personneid TO IDX_2449BA1511E3D90B');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX FK_lien_typelien ON lien');
        $this->addSql('ALTER TABLE lien DROP typelienid, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F7A506642');
        $this->addSql('DROP INDEX IDX_AF86866F7A506642 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F7A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F7A506642 ON offre (paysId )');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(3) NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE personne CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne RENAME INDEX profilid TO IDX_FCEC9EF31D26B59');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY realisation_ibfk_2');
        $this->addSql('DROP INDEX paysId ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0 NOT NULL, CHANGE resultat resultat LONGTEXT DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E7A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_EAA5610E7A506642 ON realisation (paysId )');
        $this->addSql('ALTER TABLE realisation RENAME INDEX typeclientid TO IDX_EAA5610EB6756736');
        $this->addSql('ALTER TABLE service CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle VARCHAR(254) DEFAULT NULL, CHANGE icon icon LONGTEXT NOT NULL, CHANGE lien lien LONGTEXT NOT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL, CHANGE image image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX typeserviceid TO IDX_E19D9AD2140649EB');
        $this->addSql('ALTER TABLE typeclient CHANGE image image LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE typeoffre CHANGE libelle libelle VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE typeservice CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE personneId personneId INT NOT NULL, CHANGE motDePasse motDePasse LONGTEXT NOT NULL, CHANGE roles roles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B311E3D90B FOREIGN KEY (personneId) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B311E3D90B ON utilisateur (personneId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514331EE9377');
        $this->addSql('ALTER TABLE blog CHANGE libelle libelle VARCHAR(500) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE utilisateurId utilisateurId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT blog_ibfk_1 FOREIGN KEY (utilisateurId) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog RENAME INDEX idx_c015514331ee9377 TO utilisateurId');
        $this->addSql('ALTER TABLE blog_commentaire CHANGE commentaire commentaire TEXT DEFAULT NULL, CHANGE nom nom TEXT DEFAULT NULL, CHANGE email email TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE blog_commentaire RENAME INDEX idx_bec0f442ed85fe43 TO blogId');
        $this->addSql('ALTER TABLE competence CHANGE id id INT NOT NULL, CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contactez_nous CHANGE email email VARCHAR(50) NOT NULL, CHANGE tel tel VARCHAR(50) DEFAULT NULL, CHANGE objet objet VARCHAR(50) DEFAULT NULL, CHANGE message message TEXT NOT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE description description TEXT DEFAULT NULL, CHANGE personneId personneId INT NOT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX idx_2449ba1511e3d90b TO personneId');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE lien ADD typelienid INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_lien_typelien ON lien (typelienid)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F7A506642');
        $this->addSql('DROP INDEX IDX_AF86866F7A506642 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F7A506642 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AF86866F7A506642 ON offre (paysId)');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(254) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE personne CHANGE nationalite nationalite VARCHAR(255) DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne RENAME INDEX idx_fcec9ef31d26b59 TO profilId');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E7A506642');
        $this->addSql('DROP INDEX IDX_EAA5610E7A506642 ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0, CHANGE resultat resultat TEXT DEFAULT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT realisation_ibfk_2 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX paysId ON realisation (paysId)');
        $this->addSql('ALTER TABLE realisation RENAME INDEX idx_eaa5610eb6756736 TO typeclientId');
        $this->addSql('ALTER TABLE service CHANGE id id INT NOT NULL, CHANGE libelle libelle VARCHAR(500) NOT NULL, CHANGE icon icon LONGTEXT DEFAULT NULL, CHANGE lien lien VARCHAR(500) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX idx_e19d9ad2140649eb TO typeserviceId');
        $this->addSql('ALTER TABLE typeclient CHANGE image image TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE typeoffre CHANGE libelle libelle VARCHAR(254) NOT NULL');
        $this->addSql('ALTER TABLE typeservice CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B311E3D90B');
        $this->addSql('DROP INDEX IDX_1D1C63B311E3D90B ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE motDePasse motDePasse TEXT DEFAULT NULL, CHANGE roles roles VARCHAR(255) DEFAULT NULL, CHANGE personneId personneId INT DEFAULT NULL');
    }
}
