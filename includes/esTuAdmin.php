
<?php
//permet d'éviter d'aller sur les pages uniquement accessibles aux admin
//si on n'est pas admin on retourne à l'index
if ( !(isset($_SESSION['statut'])) || ( isset($_SESSION['statut']) && $_SESSION['statut']!="admin") )
      {
        header("Location: index.php");
      }
      ?>
