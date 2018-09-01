
<?php
//permet d'éviter d'aller sur les pages uniquement accessibles aux connectés
//si on n'est pas connecté on va a la connexion
if (!(isset($_SESSION['connect'])))
      {
            header("Location: connexion.php");
      }
      ?>
