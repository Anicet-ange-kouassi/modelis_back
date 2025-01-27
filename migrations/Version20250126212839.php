<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126212839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_commentaire (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT DEFAULT NULL, nom LONGTEXT DEFAULT NULL, email LONGTEXT DEFAULT NULL, image LONGTEXT DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, blogId INT NOT NULL, INDEX IDX_BEC0F442ED85FE43 (blogId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, image LONGTEXT DEFAULT NULL, libelle VARCHAR(254) NOT NULL, description VARCHAR(254) DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_commentaire ADD CONSTRAINT FK_BEC0F442ED85FE43 FOREIGN KEY (blogId) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY blog_ibfk_1');
        $this->addSql('ALTER TABLE blog CHANGE utilisateurId utilisateurId INT NOT NULL, CHANGE libelle libelle VARCHAR(254) NOT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514331EE9377 FOREIGN KEY (utilisateurId) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE blog RENAME INDEX utilisateurid TO IDX_C015514331EE9377');
        $this->addSql('ALTER TABLE competence CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle LONGTEXT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE tel tel VARCHAR(20) NOT NULL, CHANGE adresse adresse LONGTEXT NOT NULL, CHANGE dateCreation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contact RENAME INDEX paysid TO IDX_4C62E63835569A8D');
        $this->addSql('ALTER TABLE domaine DROP libelle, DROP dateCreation, DROP dateModification, DROP dateSuppression, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX FK_domaineExperience_domaine ON domaineexperience');
        $this->addSql('DROP INDEX FK_domaineExperience_personne ON domaineexperience');
        $this->addSql('ALTER TABLE domaineexperience DROP personneId, DROP domaineId, DROP dateCreation, DROP dateModification, DROP dateSuppression, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE personneId personneId INT DEFAULT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX personneid TO IDX_2449BA1511E3D90B');
        $this->addSql('ALTER TABLE espace DROP libelle, DROP description, DROP dateCreation, DROP dateModification, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE historique CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle LONGTEXT NOT NULL, CHANGE date date DATE NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE dateModification date_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX FK_lien_typelien ON lien');
        $this->addSql('ALTER TABLE lien DROP typelienid, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE metier DROP libelle, DROP description, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE nosmetiers DROP libelle, DROP description, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_1');
        $this->addSql('DROP INDEX paysId ON offre');
        $this->addSql('ALTER TABLE offre CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F7A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F7A506642 ON offre (paysId )');
        $this->addSql('ALTER TABLE offre RENAME INDEX typeoffreid TO IDX_AF86866FD95A082E');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(3) NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE personne CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne RENAME INDEX profilid TO IDX_FCEC9EF31D26B59');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY realisation_ibfk_2');
        $this->addSql('DROP INDEX paysId ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0 NOT NULL, CHANGE resultat resultat LONGTEXT DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E7A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_EAA5610E7A506642 ON realisation (paysId )');
        $this->addSql('ALTER TABLE realisation RENAME INDEX typeclientid TO IDX_EAA5610EB6756736');
        $this->addSql('ALTER TABLE realisation_image CHANGE image image LONGTEXT DEFAULT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE realisation_image RENAME INDEX realisationid TO IDX_F9D6B0F8E8BD517');
        $this->addSql('ALTER TABLE service CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle VARCHAR(254) DEFAULT NULL, CHANGE icon icon LONGTEXT NOT NULL, CHANGE lien lien LONGTEXT NOT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL, CHANGE image image LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX typeserviceid TO IDX_E19D9AD2140649EB');
        $this->addSql('ALTER TABLE sousespace DROP espaceId, DROP libelle, DROP description, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE typeclient CHANGE image image LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE typelien CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE typeoffre CHANGE libelle libelle VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE typeservice CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP personneId, DROP email, DROP motDePasse, DROP dateCreation, DROP roles');
        $this->addSql('ALTER TABLE valeur DROP libelle, DROP description, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_commentaire DROP FOREIGN KEY FK_BEC0F442ED85FE43');
        $this->addSql('DROP TABLE blog_commentaire');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514331EE9377');
        $this->addSql('ALTER TABLE blog CHANGE libelle libelle VARCHAR(500) NOT NULL, CHANGE description description JSON DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE utilisateurId utilisateurId INT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT blog_ibfk_1 FOREIGN KEY (utilisateurId) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog RENAME INDEX idx_c015514331ee9377 TO utilisateurId');
        $this->addSql('ALTER TABLE competence CHANGE id id INT NOT NULL, CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE tel tel VARCHAR(50) NOT NULL, CHANGE adresse adresse TEXT NOT NULL, CHANGE dateCreation dateCreation DATE NOT NULL');
        $this->addSql('ALTER TABLE contact RENAME INDEX idx_4c62e63835569a8d TO paysId');
        $this->addSql('ALTER TABLE domaine ADD libelle TEXT NOT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, ADD dateSuppression DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE domaineexperience ADD personneId INT DEFAULT NULL, ADD domaineId INT NOT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, ADD dateSuppression DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_domaineExperience_domaine ON domaineexperience (domaineId)');
        $this->addSql('CREATE INDEX FK_domaineExperience_personne ON domaineexperience (personneId)');
        $this->addSql('ALTER TABLE equipe CHANGE description description TEXT DEFAULT NULL, CHANGE personneId personneId INT NOT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX idx_2449ba1511e3d90b TO personneId');
        $this->addSql('ALTER TABLE espace ADD libelle VARCHAR(254) DEFAULT NULL, ADD description VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE historique CHANGE id id INT NOT NULL, CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_modification dateModification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE lien ADD typelienid INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_lien_typelien ON lien (typelienid)');
        $this->addSql('ALTER TABLE metier MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON metier');
        $this->addSql('ALTER TABLE metier ADD libelle VARCHAR(50) DEFAULT NULL, ADD description TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE nosmetiers MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON nosmetiers');
        $this->addSql('ALTER TABLE nosmetiers ADD libelle TEXT NOT NULL, ADD description TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F7A506642');
        $this->addSql('DROP INDEX IDX_AF86866F7A506642 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE libelle libelle VARCHAR(254) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_1 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX paysId ON offre (paysId)');
        $this->addSql('ALTER TABLE offre RENAME INDEX idx_af86866fd95a082e TO typeOffreId');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(254) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE personne CHANGE nationalite nationalite VARCHAR(255) DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne RENAME INDEX idx_fcec9ef31d26b59 TO profilId');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E7A506642');
        $this->addSql('DROP INDEX IDX_EAA5610E7A506642 ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0, CHANGE resultat resultat TEXT DEFAULT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT realisation_ibfk_2 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX paysId ON realisation (paysId)');
        $this->addSql('ALTER TABLE realisation RENAME INDEX idx_eaa5610eb6756736 TO typeclientId');
        $this->addSql('ALTER TABLE realisation_image CHANGE image image TEXT NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE realisation_image RENAME INDEX idx_f9d6b0f8e8bd517 TO realisationId');
        $this->addSql('ALTER TABLE service CHANGE id id INT NOT NULL, CHANGE libelle libelle VARCHAR(500) NOT NULL, CHANGE icon icon LONGTEXT DEFAULT NULL, CHANGE lien lien VARCHAR(500) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE service RENAME INDEX idx_e19d9ad2140649eb TO typeserviceId');
        $this->addSql('ALTER TABLE sousespace MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON sousespace');
        $this->addSql('ALTER TABLE sousespace ADD espaceId INT NOT NULL, ADD libelle VARCHAR(254) DEFAULT NULL, ADD description VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE typeclient CHANGE image image TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE typelien MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON typelien');
        $this->addSql('ALTER TABLE typelien CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE typeoffre CHANGE libelle libelle VARCHAR(254) NOT NULL');
        $this->addSql('ALTER TABLE typeservice CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD personneId INT DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD motDePasse TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD roles VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE valeur MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON valeur');
        $this->addSql('ALTER TABLE valeur ADD libelle TEXT DEFAULT NULL, ADD description TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
    }
}
