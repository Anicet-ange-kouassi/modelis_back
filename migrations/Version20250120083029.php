<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120083029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_commentaire (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, nom LONGTEXT DEFAULT NULL, prenom LONGTEXT DEFAULT NULL, email LONGTEXT DEFAULT NULL, image LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE reference');
        $this->addSql('DROP INDEX FK_action_utilisateur ON action');
        $this->addSql('ALTER TABLE action DROP utilisateurId, DROP nomTable, DROP action, DROP idTable, DROP dateCreation, DROP dateModification, DROP dateSuppression, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE blog ADD date_creation DATETIME NOT NULL, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE utilisateurId utilisateur_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE client CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE libelle libelle VARCHAR(254) NOT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE competence CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle LONGTEXT NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY contact_ibfk_1');
        $this->addSql('DROP INDEX paysId ON contact');
        $this->addSql('ALTER TABLE contact CHANGE adresse adresse LONGTEXT NOT NULL, CHANGE dateModification dateModification DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE dateSuppression dateSuppression DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE paysId pays_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638A6E44244 ON contact (pays_id)');
        $this->addSql('ALTER TABLE domaine DROP libelle, DROP dateCreation, DROP dateModification, DROP dateSuppression, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX FK_domaineExperience_personne ON domaineexperience');
        $this->addSql('DROP INDEX FK_domaineExperience_domaine ON domaineexperience');
        $this->addSql('ALTER TABLE domaineexperience DROP personneId, DROP domaineId, DROP dateCreation, DROP dateModification, DROP dateSuppression, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE equipe DROP dateModification, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE personneId personneId INT DEFAULT NULL, CHANGE libelle libelle VARCHAR(254) DEFAULT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL, CHANGE mot mot LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1511E3D90B FOREIGN KEY (personneId) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE equipe RENAME INDEX fk_bureau_personne TO IDX_2449BA1511E3D90B');
        $this->addSql('ALTER TABLE espace DROP libelle, DROP description, DROP dateCreation, DROP dateModification, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE historique CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE libelle libelle LONGTEXT NOT NULL, CHANGE date date DATE NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE dateModification date_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info DROP accueilLibelle, DROP accueilDescription, DROP expertiseLibelle, DROP valeurLibelle, DROP valeurDescription, DROP expertiseAccueilLibelle, DROP expertiseAccueilDescription, DROP expertiseDescription, DROP realisationLibelle, DROP realisationDescription, DROP equipeLibelle, DROP equipeDescription, DROP carriereLibelle, DROP carriereDescription, DROP contactLibelle, DROP contactDescription, DROP blogDescription, DROP blogLibelle, DROP referenceLibelle, DROP referenceDescription, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX FK_lien_typelien ON lien');
        $this->addSql('ALTER TABLE lien DROP typelienid, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE metier DROP libelle, DROP description, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE nosmetiers DROP libelle, DROP description, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE offre DROP utilisateurId, DROP sousEspaceId, DROP typeOffreId, DROP actif, DROP libelle, DROP description, DROP dateCreation, DROP lieu, DROP image, DROP entreprise, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE personne ADD telephone VARCHAR(255) NOT NULL, ADD fonction VARCHAR(255) NOT NULL, ADD date_naissance VARCHAR(255) NOT NULL, ADD lieu_naissance VARCHAR(255) NOT NULL, ADD code_postal VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, DROP PosteFormation, DROP profilId, DROP PaysResidence, DROP nationalite, DROP linkedin, DROP siteWeb, DROP tweeter, DROP facebook, DROP tel, DROP image, DROP cv, DROP etat, DROP info, DROP dateNaissance, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE sexe sexe VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE profil DROP libelle, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE realisation DROP serviceId, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE realisation_image CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE image image LONGTEXT NOT NULL, CHANGE realisationId realisation_id INT DEFAULT NULL, CHANGE dateCreation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE service DROP typeserviceId, DROP libelle, DROP icon, DROP lien, DROP description, DROP image, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sousespace DROP espaceId, DROP libelle, DROP description, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE typelien CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE typeoffre DROP libelle, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE typeservice DROP libelle, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE utilisateur DROP personneId, DROP generer, DROP email, DROP code, DROP motDePasse, DROP dateCreation, DROP roles, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE valeur DROP libelle, DROP description, DROP dateCreation, CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reference (id INT NOT NULL, libelle VARCHAR(500) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, description TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, image TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE blog_commentaire');
        $this->addSql('ALTER TABLE action ADD utilisateurId INT DEFAULT NULL, ADD nomTable VARCHAR(254) DEFAULT NULL, ADD action VARCHAR(254) DEFAULT NULL, ADD idTable INT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateSuppression DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_action_utilisateur ON action (utilisateurId)');
        $this->addSql('ALTER TABLE blog MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON blog');
        $this->addSql('ALTER TABLE blog ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP date_creation, CHANGE id id INT NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE utilisateur_id utilisateurId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON client');
        $this->addSql('ALTER TABLE client CHANGE id id INT NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE libelle libelle VARCHAR(254) DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE competence CHANGE id id INT NOT NULL, CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE icon icon VARCHAR(500) NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A6E44244');
        $this->addSql('DROP INDEX IDX_4C62E638A6E44244 ON contact');
        $this->addSql('ALTER TABLE contact CHANGE adresse adresse TEXT NOT NULL, CHANGE dateModification dateModification DATETIME DEFAULT NULL, CHANGE dateSuppression dateSuppression DATETIME DEFAULT NULL, CHANGE pays_id paysId INT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT contact_ibfk_1 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX paysId ON contact (paysId)');
        $this->addSql('ALTER TABLE domaine ADD libelle TEXT NOT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, ADD dateSuppression DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE domaineexperience ADD personneId INT DEFAULT NULL, ADD domaineId INT NOT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, ADD dateSuppression DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_domaineExperience_personne ON domaineexperience (personneId)');
        $this->addSql('CREATE INDEX FK_domaineExperience_domaine ON domaineexperience (domaineId)');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1511E3D90B');
        $this->addSql('ALTER TABLE equipe ADD dateModification DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL, CHANGE libelle libelle VARCHAR(254) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE mot mot TEXT DEFAULT NULL, CHANGE personneId personneId INT NOT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX idx_2449ba1511e3d90b TO FK_bureau_personne');
        $this->addSql('ALTER TABLE espace ADD libelle VARCHAR(254) DEFAULT NULL, ADD description VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD dateModification DATETIME DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE historique CHANGE id id INT NOT NULL, CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE date_modification dateModification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE info ADD accueilLibelle TEXT DEFAULT NULL, ADD accueilDescription TEXT DEFAULT NULL, ADD expertiseLibelle TEXT DEFAULT NULL, ADD valeurLibelle TEXT DEFAULT NULL, ADD valeurDescription TEXT DEFAULT NULL, ADD expertiseAccueilLibelle TEXT DEFAULT NULL, ADD expertiseAccueilDescription TEXT DEFAULT NULL, ADD expertiseDescription TEXT DEFAULT NULL, ADD realisationLibelle TEXT DEFAULT NULL, ADD realisationDescription TEXT DEFAULT NULL, ADD equipeLibelle TEXT DEFAULT NULL, ADD equipeDescription TEXT DEFAULT NULL, ADD carriereLibelle TEXT DEFAULT NULL, ADD carriereDescription TEXT DEFAULT NULL, ADD contactLibelle TEXT DEFAULT NULL, ADD contactDescription TEXT DEFAULT NULL, ADD blogDescription TEXT DEFAULT NULL, ADD blogLibelle TEXT DEFAULT NULL, ADD referenceLibelle TEXT DEFAULT NULL, ADD referenceDescription TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE lien ADD typelienid INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_lien_typelien ON lien (typelienid)');
        $this->addSql('ALTER TABLE metier MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON metier');
        $this->addSql('ALTER TABLE metier ADD libelle VARCHAR(50) DEFAULT NULL, ADD description TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE nosmetiers MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON nosmetiers');
        $this->addSql('ALTER TABLE nosmetiers ADD libelle TEXT NOT NULL, ADD description TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE offre MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON offre');
        $this->addSql('ALTER TABLE offre ADD utilisateurId INT DEFAULT NULL, ADD sousEspaceId INT NOT NULL, ADD typeOffreId INT NOT NULL, ADD actif INT NOT NULL, ADD libelle VARCHAR(254) NOT NULL, ADD description TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD lieu VARCHAR(254) DEFAULT NULL, ADD image TEXT NOT NULL, ADD entreprise VARCHAR(254) DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE personne MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON personne');
        $this->addSql('ALTER TABLE personne ADD PosteFormation INT DEFAULT NULL, ADD profilId INT NOT NULL, ADD PaysResidence INT DEFAULT NULL, ADD nationalite INT DEFAULT 0, ADD linkedin VARCHAR(254) DEFAULT NULL, ADD siteWeb VARCHAR(254) DEFAULT NULL, ADD tweeter VARCHAR(254) DEFAULT NULL, ADD facebook VARCHAR(254) DEFAULT NULL, ADD tel VARCHAR(50) DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD cv TEXT DEFAULT NULL, ADD etat INT DEFAULT NULL, ADD info TEXT DEFAULT NULL, ADD dateNaissance DATE DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, DROP telephone, DROP fonction, DROP date_naissance, DROP lieu_naissance, DROP code_postal, DROP ville, DROP pays, CHANGE id id INT NOT NULL, CHANGE nom nom VARCHAR(254) NOT NULL, CHANGE prenom prenom VARCHAR(254) NOT NULL, CHANGE adresse adresse VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE sexe sexe INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profil MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON profil');
        $this->addSql('ALTER TABLE profil ADD libelle VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON realisation');
        $this->addSql('ALTER TABLE realisation ADD serviceId INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation_image MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON realisation_image');
        $this->addSql('ALTER TABLE realisation_image CHANGE id id INT NOT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE realisation_id realisationId INT DEFAULT NULL, CHANGE date_creation dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE service MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON service');
        $this->addSql('ALTER TABLE service ADD typeserviceId INT DEFAULT 0 NOT NULL, ADD libelle VARCHAR(500) NOT NULL, ADD icon VARCHAR(500) NOT NULL, ADD lien VARCHAR(500) DEFAULT NULL, ADD description TEXT DEFAULT NULL, ADD image TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE sousespace MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON sousespace');
        $this->addSql('ALTER TABLE sousespace ADD espaceId INT NOT NULL, ADD libelle VARCHAR(254) DEFAULT NULL, ADD description VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE typelien MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON typelien');
        $this->addSql('ALTER TABLE typelien CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE typeoffre MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON typeoffre');
        $this->addSql('ALTER TABLE typeoffre ADD libelle VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE typeservice MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON typeservice');
        $this->addSql('ALTER TABLE typeservice ADD libelle VARCHAR(254) DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD personneId INT DEFAULT NULL, ADD generer INT DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD code VARCHAR(255) DEFAULT NULL, ADD motDePasse TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD roles JSON DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE valeur MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON valeur');
        $this->addSql('ALTER TABLE valeur ADD libelle TEXT DEFAULT NULL, ADD description TEXT DEFAULT NULL, ADD dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id INT NOT NULL');
    }
}
