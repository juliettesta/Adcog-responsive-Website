<?php
    session_start();
?>
<!DOCTYPE html>
<html>
        <head>
    <?php
      include("includes/head.php");
      print     '<title>Connexion</title></head>';
      include("includes/header.php");
      //on vérifie que l'utilisateur n'est pas déjà connecté, si c'est le cas il est redirigé
      //arrive si l'utilisateur écrit directement l'URL
      if (isset($_SESSION['connect']) && $_SESSION['connect']=="true")
      {
          header("Location: dejaConnecte.php");
      }
    ?>
        
    <body>
        
        <?php 
        include("includes/ViderSessionFormulaire.php");
        //Bandeau de confirmation qu'un utilisateur a été créé
        if(isset ($_SESSION['UtilisateurAjoute'])){
        if ($_SESSION['UtilisateurAjoute']== true) {
            print "<div class='confirmation'> Compte créé </br>"; 
            print " Votre compte sera accessible dès validation par un admin. </br>";
            print "Login : ".$_GET['login']."</div>";
            $_SESSION['UtilisateurAjoute']= false;
            }}
            ?>
        
        <div class="container">
            <h1 class="text-center login-title">Connexion aux offres de l'AdCog</h1>
                <div class="col-sm-6 col-md-4 col-md-offset-4"  align="center">
                    <div class="imageconnexion">
                        <img class="imageProfil" alt="imageProfil" src="images\profil.jpg"/></div>
                        <div class="account-wall" >
                        <?php
                        //isset vérifie d'abord que le GET existe <=> si on a passé un argument en allant sur cette page
                        //le login ou le mot de passe est incorrect 
                          if (isset($_GET['erreur']) && $_GET['erreur']=="true")
                          {
                              echo '<div class="alert alert-info" role="alert">
                            Login ou mot de passe incorrect !
                            </div>';
                          }
                          //l'utilisateur n'est pas encore validé par un admin
                          if (isset($_GET['erreur']) && $_GET['erreur']=="nonValide")
                          {
                              echo '<div class="alert alert-info" role="alert">
                            Le compte n\'est pas encore validé !
                            </div>';
                          }
                        ?>
                        <form class="form-signin" method="POST" action="TraiteConnexion.php">
                            <input name="login" type="text" class="form-control" placeholder="Login" required autofocus>
                            <input name="mdp" type="password" class="form-control" placeholder="Mot de Passe" required></br>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
                        </form>
                    </div>
                    <a href="NouvelUser.php" class="text-center new-account">Nouvel utilisateur ?</a></br></br>
                </div>
        </div>
    </body>
                <?php
    include("includes/footer.php");
    ?>
<html/>