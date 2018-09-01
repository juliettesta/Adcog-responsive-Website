<?php
//session_start permet de réutiliser des variables globales
    session_start();

    //cas de la déconnexion
      if (isset($_SESSION['connect']) && $_SESSION['connect']=="true")
      {
              //on détruit toutes les variables de session
              session_unset();
              header("Location: connexion.php");
      }
    
    //cas de la connexion
    require("db\connect.php");
    //on vérifie que les champs sont remplis
    if (!empty($_POST['login']) and !empty($_POST['mdp'])) {
        $login = $_POST['login'];
        $mdp= $_POST['mdp'];
        //on envoie la requete où le login entré par l'utilisateur est le meme que dans la base
        $requeteConnexion = $BDD->prepare('SELECT * FROM utilisateur WHERE utilisateur_login=?');
        $requeteConnexion->execute(array($login));
        //on vérifie que le login existe dans la base de données
        if ($requeteConnexion->rowCount() == 1 )
        {
            $tableauUtilisateur=$requeteConnexion->fetch();
            //on fait le test de vérification du mot de passe crypté qui renvoie un booléen 
            $testmdp = password_verify($mdp, $tableauUtilisateur['utilisateur_mdp']);
            //c'est le bon mot de passe
            if ($testmdp) {
                //l'utilisateur a été validé par un admin
                if ($tableauUtilisateur['utilisateur_valide']==1)
                {
                    $nom=$tableauUtilisateur['utilisateur_nom'];
                    $prenom=$tableauUtilisateur['utilisateur_prenom'];
                    $statut=$tableauUtilisateur['utilisateur_statut'];
                    $id=$tableauUtilisateur['utilisateur_id'];
                    $_SESSION['login'] = $login;
                    $_SESSION['id'] = $id;
                    $_SESSION['nom'] = $nom;
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['statut'] = $statut;
                    $_SESSION['connect'] ="true";//indique que l'utilisateur est connecté
                    //on se dirige vers l'index, cette fois connecté
                    header("Location: index.php"); 
                }
                //l'utilisateur n'est pas encore valide
                else {
                    $error = "Utilisateur non validé";
                //si l'utilisateur n'est pas valide on revient a la page de connexion
                header("Location: connexion.php?erreur=nonValide");        
                }
            }
            //c'est le mauvais mot de passe
            else 
            {
                $error = "Utilisateur non reconnu";
            //si l'utilisateur n'est pas reconnu on revient a la page de connexion
            header("Location: connexion.php?erreur=true");       
            }
        }
        //c'est le mauvais mot de passe
        else {
            $error = "Utilisateur non reconnu";
            //si l'utilisateur n'est pas reconnu on revient a la page de connexion
            header("Location: connexion.php?erreur=true");        
            }
    }


