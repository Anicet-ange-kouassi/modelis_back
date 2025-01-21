-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: modelis_DB
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `action` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
/*!40000 ALTER TABLE `action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `libelle` varchar(500) NOT NULL,
  `description` longtext,
  `image` longtext,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_commentaire`
--

DROP TABLE IF EXISTS `blog_commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_id` int NOT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci,
  `nom` longtext COLLATE utf8mb4_unicode_ci,
  `prenom` longtext COLLATE utf8mb4_unicode_ci,
  `email` longtext COLLATE utf8mb4_unicode_ci,
  `image` longtext COLLATE utf8mb4_unicode_ci,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_commentaire`
--

LOCK TABLES `blog_commentaire` WRITE;
/*!40000 ALTER TABLE `blog_commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competence`
--

DROP TABLE IF EXISTS `competence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competence` (
  `id` int NOT NULL,
  `libelle` text,
  `description` text,
  `icon` varchar(500) NOT NULL,
  `image` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence`
--

LOCK TABLES `competence` WRITE;
/*!40000 ALTER TABLE `competence` DISABLE KEYS */;
/*!40000 ALTER TABLE `competence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `adresse` text NOT NULL,
  `dateCreation` date NOT NULL,
  `paysId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paysId` (`paysId`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`paysId`) REFERENCES `pays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'contact@modelis-tech.com','(+225) 21 74 84 34','COCODY FAYA EN FACE DE LA CLINIQUE BON SAMARITAIN, Abidjan','2025-01-21',1),(2,'contact@modelis-tech.fr','(+33) 1 23 45 67 89','Paris, France','2025-01-21',2),(3,'contact@modelis-tech.se','(+221) 23 45 56 789','Dakar, Sénégal','2025-01-21',3),(4,'contact@modelis-tech.ml','(+223) 23 45 56 789','Bamako,Mali','2025-01-21',4);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domaine` (
  `id` int NOT NULL,
  `libelle` text NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime DEFAULT NULL,
  `dateSuppression` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine`
--

LOCK TABLES `domaine` WRITE;
/*!40000 ALTER TABLE `domaine` DISABLE KEYS */;
/*!40000 ALTER TABLE `domaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaineexperience`
--

DROP TABLE IF EXISTS `domaineexperience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domaineexperience` (
  `id` int NOT NULL,
  `personneId` int DEFAULT NULL,
  `domaineId` int NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime DEFAULT NULL,
  `dateSuppression` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_domaineExperience_domaine` (`domaineId`),
  KEY `FK_domaineExperience_personne` (`personneId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaineexperience`
--

LOCK TABLES `domaineexperience` WRITE;
/*!40000 ALTER TABLE `domaineexperience` DISABLE KEYS */;
/*!40000 ALTER TABLE `domaineexperience` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipe` (
  `id` int NOT NULL,
  `personneId` int NOT NULL,
  `libelle` varchar(254) NOT NULL,
  `description` text,
  `mot` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_bureau_personne` (`personneId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipe`
--

LOCK TABLES `equipe` WRITE;
/*!40000 ALTER TABLE `equipe` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `espace`
--

DROP TABLE IF EXISTS `espace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `espace` (
  `id` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `description` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `espace`
--

LOCK TABLES `espace` WRITE;
/*!40000 ALTER TABLE `espace` DISABLE KEYS */;
/*!40000 ALTER TABLE `espace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historique`
--

DROP TABLE IF EXISTS `historique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historique` (
  `id` int NOT NULL,
  `libelle` text,
  `date` date DEFAULT NULL,
  `description` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateModification` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historique`
--

LOCK TABLES `historique` WRITE;
/*!40000 ALTER TABLE `historique` DISABLE KEYS */;
INSERT INTO `historique` VALUES (1,'Notre <strong>histoire</strong>','2020-12-01','Le groupe Modelis s\'est créé et se développe autour d\'une unique motivation : répondre aux besoins de nos clients. C\'est pourquoi, il s\'est adapté au fil des années en spécialisant ses équipes autour des trois domaines prioritaires : la topographie, la géomatique et le génie civil.<br><br>La base du groupe Modelis se trouve en Côte d\'ivoire. Nous restons attachés à cela et ambitionnons de créer une multi-nationale ancrée dans les valeurs et la culture africaine.<br><span><br>Partout où le groupe Modelis ira, le client sera toujours au cœur de notre attention. C\'est notre motivation et celle de nos équipes au quotidien : offrir la plus grande valeur ajoutée à nos clients.</span>','2025-01-20 14:12:33','2025-01-20 14:12:33'),(2,'libelle 1','2018-06-01','description','2025-01-20 14:12:33','2025-01-20 14:12:33'),(3,'libelle 2','2014-04-29','description','2025-01-20 14:12:33','2025-01-20 14:12:33');
/*!40000 ALTER TABLE `historique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info` (
  `id` int NOT NULL,
  `accueilLibelle` text,
  `accueilDescription` text,
  `expertiseLibelle` text,
  `valeurLibelle` text,
  `valeurDescription` text,
  `expertiseAccueilLibelle` text,
  `expertiseAccueilDescription` text,
  `expertiseDescription` text,
  `realisationLibelle` text,
  `realisationDescription` text,
  `equipeLibelle` text,
  `equipeDescription` text,
  `carriereLibelle` text,
  `carriereDescription` text,
  `contactLibelle` text,
  `contactDescription` text,
  `blogDescription` text,
  `blogLibelle` text,
  `referenceLibelle` text,
  `referenceDescription` text,
  `image` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info`
--

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lien`
--

DROP TABLE IF EXISTS `lien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lien` (
  `id` int NOT NULL,
  `typelienid` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `lien` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_lien_typelien` (`typelienid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lien`
--

LOCK TABLES `lien` WRITE;
/*!40000 ALTER TABLE `lien` DISABLE KEYS */;
INSERT INTO `lien` VALUES (1,1,'MODELIS GROUP','https://modelisgroup.com/','2025-01-17 00:00:00'),(2,2,'Site de vente en ligne','https://shop.modelis-gis.com/','2025-01-17 00:00:00'),(3,3,'Catalogue en ligne','https://catalogue.modelis-gis.com/','2025-01-17 00:00:00'),(4,4,'Logiciel EasyTopo','https://www.easytopo.fr/','2025-01-17 00:00:00'),(5,5,'Site de Formation MODELIS','https://formation.easytopo.fr/','2025-01-17 00:00:00'),(6,3,'MODELIS TECH','https://modelis-tech.com/','2025-01-17 00:00:00'),(7,6,'Modelis-Gc','https://modelis-gc.com/','2025-01-17 00:00:00'),(8,5,'Modelis-Gis','https://modelis-gis.com/','2025-01-17 00:00:00'),(9,7,'Modelis-Tech','http://modelis-tech.com/','2025-01-17 00:00:00'),(10,8,'Modelis-France','http://modelis-france.com/','2025-01-17 00:00:00'),(11,5,'Modelis-Sénégal','http://modelis-senegal.com/','2025-01-17 00:00:00'),(12,9,'Modelis-Mali','http://demo.modelis-mali.com/','2025-01-17 00:00:00'),(13,10,'Modelis-Group','https://modelisgroup.com/','2025-01-17 00:00:00');
/*!40000 ALTER TABLE `lien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metier`
--

DROP TABLE IF EXISTS `metier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metier` (
  `id` int NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  `description` text,
  `image` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metier`
--

LOCK TABLES `metier` WRITE;
/*!40000 ALTER TABLE `metier` DISABLE KEYS */;
/*!40000 ALTER TABLE `metier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nosmetiers`
--

DROP TABLE IF EXISTS `nosmetiers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nosmetiers` (
  `id` int NOT NULL,
  `libelle` text NOT NULL,
  `description` text,
  `image` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nosmetiers`
--

LOCK TABLES `nosmetiers` WRITE;
/*!40000 ALTER TABLE `nosmetiers` DISABLE KEYS */;
/*!40000 ALTER TABLE `nosmetiers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offre`
--

DROP TABLE IF EXISTS `offre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offre` (
  `id` int NOT NULL,
  `utilisateurId` int DEFAULT NULL,
  `sousEspaceId` int NOT NULL,
  `typeOffreId` int NOT NULL,
  `actif` int NOT NULL,
  `libelle` varchar(254) NOT NULL,
  `description` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lieu` varchar(254) DEFAULT NULL,
  `image` text NOT NULL,
  `entreprise` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offre`
--

LOCK TABLES `offre` WRITE;
/*!40000 ALTER TABLE `offre` DISABLE KEYS */;
/*!40000 ALTER TABLE `offre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(254) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays`
--

LOCK TABLES `pays` WRITE;
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
INSERT INTO `pays` VALUES (1,'CIV','Côte d\'Ivoire'),(2,'FR','France'),(3,'SE','Sénégal'),(4,'ML','Mali');
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personne`
--

DROP TABLE IF EXISTS `personne`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profilId` int NOT NULL,
  `PaysResidence` varchar(255) DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  `nom` varchar(254) NOT NULL,
  `prenom` varchar(254) NOT NULL,
  `linkedin` varchar(254) DEFAULT NULL,
  `sexe` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `image` text,
  `dateNaissance` date DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `profilId` (`profilId`),
  CONSTRAINT `personne_ibfk_1` FOREIGN KEY (`profilId`) REFERENCES `profil` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personne`
--

LOCK TABLES `personne` WRITE;
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
/*!40000 ALTER TABLE `personne` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil`
--

LOCK TABLES `profil` WRITE;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
INSERT INTO `profil` VALUES (1,'Super Administrateur','2025-01-21 10:10:36'),(2,'Administrateur Système','2025-01-21 10:10:36'),(3,'Administrateur Réseau','2025-01-21 10:10:36'),(4,'Développeur Front-End','2025-01-21 10:10:36'),(5,'Développeur Back-End','2025-01-21 10:10:36'),(6,'Développeur Full-Stack','2025-01-21 10:10:36'),(7,'Ingénieur DevOps','2025-01-21 10:10:36'),(8,'Architecte Logiciel','2025-01-21 10:10:36'),(9,'Responsable Technique','2025-01-21 10:10:36'),(10,'Chef de Projet Technique','2025-01-21 10:10:36'),(11,'Ingénieur QA (Qualité)','2025-01-21 10:10:36'),(12,'Chef de Projet','2025-01-21 10:10:36'),(13,'Scrum Master','2025-01-21 10:10:36'),(14,'Product Owner','2025-01-21 10:10:36'),(15,'Responsable Marketing','2025-01-21 10:10:36'),(16,'Community Manager','2025-01-21 10:10:36'),(17,'Responsable Communication','2025-01-21 10:10:36'),(18,'Directeur Général','2025-01-21 10:10:36'),(19,'Directeur Technique (CTO)','2025-01-21 10:10:36'),(20,'Directeur des Opérations (COO)','2025-01-21 10:10:36'),(21,'Directeur Commercial (CCO)','2025-01-21 10:10:36'),(22,'Responsable Support','2025-01-21 10:10:36'),(23,'Technicien Support','2025-01-21 10:10:36'),(24,'Consultant Fonctionnel','2025-01-21 10:10:36'),(25,'Responsable RH','2025-01-21 10:10:36'),(26,'Chargé de Recrutement','2025-01-21 10:10:36'),(27,'Analyste de Données','2025-01-21 10:10:36'),(28,'Responsable Sécurité Informatique','2025-01-21 10:10:36'),(29,'Designer UX/UI','2025-01-21 10:10:36'),(30,'Stagiaire','2025-01-21 10:10:36'),(31,'Responsable Géomaticien','2025-01-21 10:12:33'),(32,'President','2025-01-21 10:46:40'),(33,'Developpeur Geomaticien','2025-01-21 10:58:05');
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `realisation`
--

DROP TABLE IF EXISTS `realisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `realisation` (
  `id` int NOT NULL,
  `serviceId` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `lieu` varchar(254) DEFAULT NULL,
  `description` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `serviceId` (`serviceId`),
  CONSTRAINT `realisation_ibfk_1` FOREIGN KEY (`serviceId`) REFERENCES `service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realisation`
--

LOCK TABLES `realisation` WRITE;
/*!40000 ALTER TABLE `realisation` DISABLE KEYS */;
INSERT INTO `realisation` VALUES (1,1,'Réhabilitation du poste 0 de Yamoussoukro','2020-10-01','Yamoussoukro, Cote d\'îvoire','Il s\'agissait de réhabiliter le bâtiment de commande existant, délaissé depuis plusieurs années; reprendre la plate-forme de la cour de ce poste et réhabiliter la clôture et les accès au poste','2025-01-20 14:48:13'),(2,2,'Construction du poste 225kv de Bingerville (1ère partie)','2020-11-03','Bingerville, Cote d\'îvoire','Dans ce projet, nous avions réaliser uniquement des massifs supports charpentes métalliques\r\nDélai d\'exécution: 3 mois\r\n','2025-01-20 14:48:13'),(3,3,'Création d\'une nouvelle travée 90/30kv dans les villes de Abengourou et Agnibilekrou','2020-08-09','Abengourou et agnibilekrou en Cote d\'îvoir','nous avions à réaliser :\r\ndes massifs supports charpentes métalliques, \r\nune fosse TFO;\r\nun mur pare-feu;\r\nune piste de roulement\r\nles caniveaux BT et HT\r\nDélai d\'exécution: 6 mois\r\n','2025-01-20 14:48:13'),(4,4,'Construction du poste 225kv d\'Anani route Bassam','2020-07-09','Bassam, Cote d\'îvoire','Dans ce projet nous avons réaliser uniquement des massifs supports charpentes métalliques','2025-01-20 14:48:13'),(5,5,'Création d\'une nouvelle travée 90/30kv au poste de Man','2020-09-11','Cote d\'îvoire','nous avions à réaliser, dans le cadre de ce projet:\r\ndes massifs supports charpentes métalliques;\r\nune fosse TFO;\r\nune piste de roulement\r\nDélai d\'exécution 5 mois\r\n','2025-01-20 14:48:13'),(6,2,'création d\'une nouvelle travée 225kv plan b au poste de Bingerville','2020-12-09','Bingerville Cote d\'îvoire','Il s\'agissait pour nous ici de réaliser:\r\nun bâtiment de commande;\r\nune fosse TFO;\r\nune piste de roulement;\r\nles massifs supports charpentes;\r\nles caniveaux BT et HTA\r\nDélai d\'exécution : 4 mois\r\n','2025-01-20 14:48:13'),(7,1,'Construction du poste 225kv de Bingerville (1ère partie) avec VINCI','2020-11-03','Bingerville, Cote d\'îvoire','Dans ce projet, nous avions réaliser uniquement des massifs supports charpentes métalliques Délai d\'exécution: 3 mois','2025-01-20 14:48:13'),(8,3,'Construction du poste 225kv de Bingerville (2iè partie ) avec MRI','2021-01-12','Bingerville, Cote d\'îvoire',NULL,'2025-01-20 14:48:13'),(9,5,'Poste Bingerville - plan B VINCI','2021-01-01','Bingerville, Cote d\'îvoire',NULL,'2025-01-20 14:48:13'),(10,2,'Construction du poste 225kv d\'Anani route Bassam','2021-01-01','Anani, Cote d\'îvoire','Dans ce projet nous avons réaliser uniquement des massifs supports charpentes métalliques','2025-01-20 14:48:13'),(11,1,'Construction du poste Antula','2021-01-01','GUINEE BISSAU',NULL,'2025-01-20 14:48:13'),(12,3,'Construction du poste électrique de Danané','2021-01-01','Danané','construction de&nbsp;<b>bâtiment HTA</b>&nbsp;et de&nbsp;<b>poste extérieur</b><br>Réhabilitation de <b>bâtiment&nbsp;de commande</b> et de <b>logements d\'exploitation</b>','2025-01-20 14:48:13'),(13,2,'Construction du poste électrique de Taabo','2021-01-01','Taabo','construction de&nbsp;<b>bâtiment HTA</b>&nbsp;et de&nbsp;<b>poste extérieur</b>','2025-01-20 14:48:13'),(14,5,'Construction du poste électrique de Man','2021-01-01','Man','construction de&nbsp;<b>bâtiment HTA</b>&nbsp;et de&nbsp;<b>poste extérieur</b>','2025-01-20 14:48:13'),(15,4,'Construction du poste de Zagné','2021-01-01','Zagné','construction de <b>bâtiment HTA</b> et de <b>poste extérieur</b>','2025-01-20 14:48:13'),(16,1,'Livraison de materiel à la DTC','2019-07-02','Cote d\'îvoire','Livraison de  materiel à la DTC ( Direction de la Topographie et de la Cartographie) image de stock de materiel joints <br>','2025-01-20 14:48:13');
/*!40000 ALTER TABLE `realisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `realisation_image`
--

DROP TABLE IF EXISTS `realisation_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `realisation_image` (
  `id` int NOT NULL,
  `realisationId` int DEFAULT NULL,
  `image` text,
  `description` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `realisationId` (`realisationId`),
  CONSTRAINT `realisation_image_ibfk_1` FOREIGN KEY (`realisationId`) REFERENCES `realisation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `realisation_image`
--

LOCK TABLES `realisation_image` WRITE;
/*!40000 ALTER TABLE `realisation_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `realisation_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int NOT NULL,
  `typeservice_id` int NOT NULL,
  `libelle` varchar(500) NOT NULL,
  `icon` longtext,
  `lien` varchar(500) DEFAULT NULL,
  `description` text,
  `image` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `typeserviceId` (`typeservice_id`),
  CONSTRAINT `service_ibfk_1` FOREIGN KEY (`typeservice_id`) REFERENCES `typeservice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,1,'Ingénierie de projet de génie civil','<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"currentColor\" class=\"size-6\">\n  <path fill-rule=\"evenodd\" d=\"M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z\" clip-rule=\"evenodd\" />\n  </svg>',NULL,'Accompagnement dans la Phase d\'avant-Projet et l\'étude des besoins.','images/service/bg-ingenierie.png','2025-01-20 11:44:08'),(2,1,'Réalisation de postes électriques','fa fa-road',NULL,'MODELIS GC dispose de très bonnes références en matière de construction de poste électrique.','images/service/bg-electric.png','2025-01-20 11:44:08'),(3,1,'Suivi et contrôle de chantier','<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" class=\"size-6\">\n  <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z\" /></svg>',NULL,'MODELIS GC peut accompagner ses clients de la phase d\'avant projet jusqu’à la livraison du projet. Nous disposons de l\'expérience nécessaire en matière de gestion de projet.','images/service/bg-suivis.png','2025-01-20 11:44:08'),(4,1,'Travaux de construction et de rénovation de bâtiment','fa fa-stop',NULL,'MODELIS GC réalise tous types de travaux en bâtiment. Qu’il s’agisse de la construction ou de la rénovation de bâtiments anciens.','images/service/bg-construction.jpg','2025-01-20 11:44:08'),(5,1,'Formation','fa fa-road',NULL,'Des ingénieurs spécialisés en génie civil fournissent à vos collaborateurs des formations sur mesure.','images/service/bg-formation.jpg','2025-01-20 11:44:08');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sousespace`
--

DROP TABLE IF EXISTS `sousespace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sousespace` (
  `id` int NOT NULL,
  `espaceId` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `description` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sousespace`
--

LOCK TABLES `sousespace` WRITE;
/*!40000 ALTER TABLE `sousespace` DISABLE KEYS */;
/*!40000 ALTER TABLE `sousespace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeclient`
--

DROP TABLE IF EXISTS `typeclient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typeclient` (
  `id` int NOT NULL,
  `image` text,
  `description` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeclient`
--

LOCK TABLES `typeclient` WRITE;
/*!40000 ALTER TABLE `typeclient` DISABLE KEYS */;
INSERT INTO `typeclient` VALUES (1,'/images/client/2b4e242f393aab426ec16c22eaec29f3.png','Description pour le client 1.','2025-01-21 00:44:28'),(2,'/images/client/7e60276e4bf86f08430bb1b12e94419f.png','Description pour le client 2.','2025-01-21 00:44:28'),(3,'/images/client/45ee3e420497863b20bd551a33868cdc.png','Description pour le client 3.','2025-01-21 00:44:28'),(4,'/images/client/68cc0f501dae74a9075358959562797b.png','Description pour le client 4.','2025-01-21 00:44:28'),(5,'/images/client/80a50c59c25997b144b8a20da1252cec.jpg','Description pour le client 5.','2025-01-21 00:44:28'),(6,'/images/client/8402c43cde81a4c87927cff61ba5c2ce.png','Description pour le client 6.','2025-01-21 00:44:28');
/*!40000 ALTER TABLE `typeclient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typelien`
--

DROP TABLE IF EXISTS `typelien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typelien` (
  `id` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typelien`
--

LOCK TABLES `typelien` WRITE;
/*!40000 ALTER TABLE `typelien` DISABLE KEYS */;
INSERT INTO `typelien` VALUES (1,'Autres liens','2025-01-17 16:26:20'),(2,'Liens utiles','2025-01-17 16:27:30'),(3,'groupe','2025-01-17 16:28:50');
/*!40000 ALTER TABLE `typelien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeoffre`
--

DROP TABLE IF EXISTS `typeoffre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typeoffre` (
  `id` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeoffre`
--

LOCK TABLES `typeoffre` WRITE;
/*!40000 ALTER TABLE `typeoffre` DISABLE KEYS */;
/*!40000 ALTER TABLE `typeoffre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeservice`
--

DROP TABLE IF EXISTS `typeservice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `typeservice` (
  `id` int NOT NULL,
  `libelle` varchar(254) DEFAULT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeservice`
--

LOCK TABLES `typeservice` WRITE;
/*!40000 ALTER TABLE `typeservice` DISABLE KEYS */;
INSERT INTO `typeservice` VALUES (1,'Global','2025-01-20 11:18:56');
/*!40000 ALTER TABLE `typeservice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `id` int NOT NULL,
  `personneId` int DEFAULT NULL,
  `generer` int DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `motDePasse` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roles` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valeur`
--

DROP TABLE IF EXISTS `valeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valeur` (
  `id` int NOT NULL,
  `libelle` text,
  `description` text,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valeur`
--

LOCK TABLES `valeur` WRITE;
/*!40000 ALTER TABLE `valeur` DISABLE KEYS */;
/*!40000 ALTER TABLE `valeur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-21 12:54:45
