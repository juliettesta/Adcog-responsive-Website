drop table if exists liaison_entrepriseadresse;
drop table if exists liaison_panier;
drop table if exists offre;
drop table if exists utilisateur;
drop table if exists contact;
drop table if exists entreprise;
drop table if exists adresse;



/* Création de la table Adresse */
CREATE TABLE `adresse` (
  `adresse_id` integer primary key auto_increment,
  `adresse_voie` tinytext COLLATE utf8_unicode_ci,
  `adresse_ville` tinytext COLLATE utf8_unicode_ci,
  `adresse_cp` int(11),
  `adresse_pays` tinytext COLLATE utf8_unicode_ci 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 

/* Création de la table Entreprise */
CREATE TABLE `entreprise` (
  `entreprise_id` integer primary key auto_increment,
  `entreprise_nom` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `entreprise_siteInternet` tinytext COLLATE utf8_unicode_ci,
  `entreprise_descrCourte` longtext COLLATE utf8_unicode_ci,
  `entreprise_descrLong` longtext COLLATE utf8_unicode_ci NOT NULL,
  `entreprise_logo` tinytext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* Création de la table utilisateur */
CREATE TABLE `utilisateur` (
  `utilisateur_id` integer primary key auto_increment,
  `utilisateur_nom` tinytext COLLATE utf8_unicode_ci,
  `utilisateur_prenom` tinytext COLLATE utf8_unicode_ci,
  `utilisateur_dateNaissance` date DEFAULT NULL,
  `utilisateur_dateInscription` date NOT NULL,
  `utilisateur_statut` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Admin, normal, adhérent',
  `utilisateur_mail` tinytext COLLATE utf8_unicode_ci,
  `utilisateur_tel` tinytext COLLATE utf8_unicode_ci,
  `utilisateur_mdp` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `utilisateur_login` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `adresse_id` int(11) DEFAULT NULL,
  `utilisateur_valide` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`adresse_id`);

/* Création de la table contact */
CREATE TABLE `contact` (
  `contact_id` integer primary key auto_increment,
  `contact_nom` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `contact_prenom` tinytext COLLATE utf8_unicode_ci,
  `contact_tel` tinytext COLLATE utf8_unicode_ci,
  `contact_mail` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `entreprise_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`entreprise_id`);

/* Création de la table liaison_entrepriseadresse : liason n/n entre les deux tables*/
CREATE TABLE `liaison_entrepriseadresse` (
  `liaisonEntre_id` integer primary key auto_increment,
  `entreprise_id` int(11) NOT NULL,
  `adresse_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `liaison_entrepriseadresse`
  ADD CONSTRAINT `liaison_entrepriseadresse_ibfk_1` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`entreprise_id`),
  ADD CONSTRAINT `liaison_entrepriseadresse_ibfk_2` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`adresse_id`);

/* Création de la table offre */
CREATE TABLE `offre` (
  `offre_id` integer primary key auto_increment,
  `offre_nom` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `offre_datePoste` date NOT NULL,
  `offre_mdp` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `offre_profil` tinytext COLLATE utf8_unicode_ci NOT NULL COMMENT 'Stage, Emploi',
  `offre_dateDeb` date DEFAULT NULL,
  `offre_duree` tinytext COLLATE utf8_unicode_ci,
  `offre_descrCourte` tinytext COLLATE utf8_unicode_ci,
  `offre_descrLongue` longtext COLLATE utf8_unicode_ci NOT NULL,
  `offre_fichier` tinytext COLLATE utf8_unicode_ci,
  `offre_valide` tinyint(1) DEFAULT NULL,
  `offre_signalee` tinyint(1) DEFAULT NULL,
  `offre_renum` tinytext COLLATE utf8_unicode_ci,
  `contact_id` int(11) NOT NULL,
  `entreprise_id` int(11) NOT NULL,
  `adresse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `offre`
  ADD CONSTRAINT `offre_ibfk_1` FOREIGN KEY (`entreprise_id`) REFERENCES `entreprise` (`entreprise_id`),
  ADD CONSTRAINT `offre_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`contact_id`),
  ADD CONSTRAINT `offre_ibfk_3` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`adresse_id`);

/* Création de la liason panier  : liaison n/n entre l'utilisateur et les offres */
CREATE TABLE `liaison_panier` (
  `liaisonPanier_id` integer primary key auto_increment,
  `liaisonPanier_postule` tinyint(1),
  `utilisateur_id` int(11) NOT NULL,
  `offre_id` int(11) NOT NULL,
  `liaisonPanier_save` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `liaison_panier`
  ADD CONSTRAINT `liaison_panier_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`utilisateur_id`),
  ADD CONSTRAINT `liaison_panier_ibfk_2` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`offre_id`);
