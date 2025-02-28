<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226141706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expertise (id INT AUTO_INCREMENT NOT NULL, typeservice_id INT NOT NULL, libelle VARCHAR(254) DEFAULT NULL, icon LONGTEXT NOT NULL, lien LONGTEXT NOT NULL, description VARCHAR(254) DEFAULT NULL, image LONGTEXT NOT NULL, dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, paysId  INT NOT NULL, INDEX IDX_E19D9AD2140649EB (typeservice_id), INDEX IDX_E19D9AD27A506642 (paysId ), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typeservice (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(254) DEFAULT NULL, dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expertise ADD CONSTRAINT FK_E19D9AD2140649EB FOREIGN KEY (typeservice_id) REFERENCES typeservice (id)');
        $this->addSql('ALTER TABLE expertise ADD CONSTRAINT FK_E19D9AD27A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('ALTER TABLE client CHANGE image image LONGTEXT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe CHANGE personneId personneId INT DEFAULT NULL, CHANGE description description VARCHAR(254) DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA157A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_2449BA157A506642 ON equipe (paysId )');
        $this->addSql('ALTER TABLE equipe RENAME INDEX personneid TO IDX_2449BA1511E3D90B');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX FK_lien_typelien ON lien');
        $this->addSql('ALTER TABLE lien DROP typelienid, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(3) NOT NULL, CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE personnelle CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE image image LONGTEXT DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE personnelle ADD CONSTRAINT FK_8E464E087A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_8E464E087A506642 ON personnelle (paysId )');
        $this->addSql('ALTER TABLE personnelle RENAME INDEX profilid TO IDX_8E464E0831D26B59');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY realisation_ibfk_2');
        $this->addSql('DROP INDEX paysId ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle VARCHAR(500) DEFAULT NULL, CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0 NOT NULL, CHANGE resultat resultat LONGTEXT DEFAULT NULL, CHANGE paysId paysId  INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E7A506642 FOREIGN KEY (paysId ) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_EAA5610E7A506642 ON realisation (paysId )');
        $this->addSql('ALTER TABLE realisation RENAME INDEX typeclientid TO IDX_EAA5610EEA1CE9BE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expertise (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(500) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, icon LONGTEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, lien VARCHAR(500) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, description TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, image TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, dateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, paysId INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE expertise DROP FOREIGN KEY FK_E19D9AD2140649EB');
        $this->addSql('ALTER TABLE expertise DROP FOREIGN KEY FK_E19D9AD27A506642');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE typeservice');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE info CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE lien ADD typelienid INT NOT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('CREATE INDEX FK_lien_typelien ON lien (typelienid)');
        $this->addSql('ALTER TABLE pays CHANGE code code VARCHAR(254) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE personnelle DROP FOREIGN KEY FK_8E464E087A506642');
        $this->addSql('DROP INDEX IDX_8E464E087A506642 ON personnelle');
        $this->addSql('ALTER TABLE personnelle CHANGE nationalite nationalite VARCHAR(255) DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE personnelle RENAME INDEX idx_8e464e0831d26b59 TO profilId');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA157A506642');
        $this->addSql('DROP INDEX IDX_2449BA157A506642 ON equipe');
        $this->addSql('ALTER TABLE equipe CHANGE description description TEXT DEFAULT NULL, CHANGE personneId personneId INT NOT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE equipe RENAME INDEX idx_2449ba1511e3d90b TO personneId');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E7A506642');
        $this->addSql('DROP INDEX IDX_EAA5610E7A506642 ON realisation');
        $this->addSql('ALTER TABLE realisation CHANGE libelle libelle TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE enCours enCours TINYINT(1) DEFAULT 0, CHANGE resultat resultat TEXT DEFAULT NULL, CHANGE paysId  paysId INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT realisation_ibfk_2 FOREIGN KEY (paysId) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX paysId ON realisation (paysId)');
        $this->addSql('ALTER TABLE realisation RENAME INDEX idx_eaa5610eea1ce9be TO typeclientId');
        $this->addSql('ALTER TABLE client CHANGE image image TEXT DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
    }
}
