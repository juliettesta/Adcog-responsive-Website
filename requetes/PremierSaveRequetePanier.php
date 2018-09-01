<?php
    require("../db/connect.php");
    if (isset ($_POST["utilisateur"]) && isset($_POST["offre"]))
    {
        $requete=$BDD->prepare('INSERT INTO `liaison_panier` (`liaisonPanier_id`, `liaisonPanier_postule`, `utilisateur_id`, `offre_id`, `liaisonPanier_save`) VALUES (NULL, "0", ?, ?,"1");');
        $requete->execute(array($_POST["utilisateur"],$_POST["offre"]));
        $requete=$BDD->prepare('SELECT liaisonPanier_id FROM liaison_panier WHERE utilisateur_id=? AND offre_id=?;');
        $requete->execute(array($_POST["utilisateur"],$_POST["offre"]));      
        $liaison=$requete->fetch();
        echo $liaison["liaisonPanier_id"];
    }
?>