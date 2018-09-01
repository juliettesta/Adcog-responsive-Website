/* Quand on insert les données, on remplit les tables n'ayant pas de clés étrangères en premier.
Ceci permet de pouvoir utiliser ces données dans tables suivantes 

On insert pas l'id car il est auto incrémenté */


/* Insertion des adresses */
INSERT INTO `adresse` (`adresse_voie`, `adresse_ville`, `adresse_cp`, `adresse_pays`) VALUES
('130 rue Gambetta', 'Bordeaux', 33000, 'France'),
('56 chemin des arbres', 'Grenoble', 38000, 'France'),
('Rue des olives', 'Bordeaux', 33000, 'France');

/* Insertion des entreprises */
INSERT INTO `entreprise` (`entreprise_nom`, `entreprise_siteInternet`, `entreprise_descrCourte`, `entreprise_descrLong`, `entreprise_logo`) VALUES
('entrepriseNom', 'http://www.entreprise.fr/', 'et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je ', 'et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je blablate et je ', 'entrepriseLogo.jpg'),
('Entreprise', 'http://www.google.com', 'description courte', 'descrip descript descrip descript', 'logoensc.png'),
(' Entreprise Cognitique', 'http://cognitique.fr', 'Description courte', 'Ceci est une description longue', NULL);

/* Insertion des utilisateurs */
INSERT INTO `utilisateur` ( `utilisateur_nom`, `utilisateur_prenom`, `utilisateur_dateNaissance`, `utilisateur_dateInscription`, `utilisateur_statut`, `utilisateur_mail`, `utilisateur_tel`, `utilisateur_mdp`, `utilisateur_login`, `adresse_id`, `utilisateur_valide`) VALUES
('nomNormal', 'PrenomNormal', '1996-08-13', '2017-08-03', 'normal', 'normal@ensc.fr', '0776543627', 'secret', 'LoginNormal', 1, 1),
('nomAdmin', 'PrenomAdmin', '1975-08-21', '2017-02-21', 'admin', 'admin@ensc.fr', '0867543465', 'secret ', 'loginAdmin', NULL, 1),
('nomAdherent', 'PrenomAdherent', '1987-01-31', '2017-06-09', 'adherent', 'adherent@ensc.com', '0876543689', 'secret', 'loginAdherent', NULL, 1);

/* Insertion des contacts */
INSERT INTO `contact` (`contact_nom`, `contact_prenom`, `contact_tel`, `contact_mail`, `entreprise_id`) VALUES
('nomContact', 'prenomContact', '0978654638', 'nomContact@ensc.fr', 1),
('Dupont', 'Joe', NULL, 'jdupont@mail.com', 1),
('Dupond', 'Benjamin', NULL, 'bdupond@mail.com', 2),
('Smith', 'Alfred', NULL, 'asmith@mail.com', 3);

/* Insertion des liasons entreprises/adresses */
INSERT INTO `liaison_entrepriseadresse` (`entreprise_id`, `adresse_id`) VALUES
(1, 2),
(2, 3);

/* Insertion des offres */
INSERT INTO `offre` (`offre_nom`, `offre_datePoste`, `offre_mdp`, `offre_profil`, `offre_dateDeb`, `offre_duree`, `offre_descrCourte`, `offre_descrLongue`, `offre_fichier`, `offre_valide`, `offre_signalee`, `offre_renum`, `contact_id`, `entreprise_id`, `adresse_id`) VALUES
('Stage n°1', '2017-03-09', 'mdp1', 'Stage', '2017-05-28', '5 mois', 'descrpition courte', 'description plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longuedescription plus longue', '', 1, 0, '500 euros/Mois', 4, 3, null),
('Offre d emploi', '2017-01-01', 'secret', 'Emploi', '2017-07-07', 'CDI ', ' description courte', ' description longue', 'offreEmploi.docx', 1, 0, '1800 euros/Mois', 2, 1, 2),
('Stage n°2', '2017-04-03', 'password', 'Stage', '2017-08-12', '4 semaines minimum', ' description courte', 'description longue', '', 1, 0, '0 euros/Semaine', 3, 2, 3);

/* Insertion des liaisons panier*/
INSERT INTO `liaison_panier` ( `liaisonPanier_postule`, `utilisateur_id`, `offre_id`, `liaisonPanier_save`) VALUES
(1, 1, 1, 0),
(1, 3, 2, 1),
(0, 1, 3, 1),
(0, 3, 1, 1);