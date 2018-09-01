<?php
    require("../db/connect.php");
    if (isset ($_POST["offre"]))
    {
        $requete=$BDD->prepare('DELETE FROM liaison_panier WHERE offre_id=?;'
                . 'DELETE FROM offre WHERE offre_id=?;');
        $requete->execute(array($_POST["offre"],$_POST["offre"]));
    }
?>