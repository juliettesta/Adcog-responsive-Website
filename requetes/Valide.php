<?php
    require("../db/connect.php");
    if (isset ($_POST["offre"]))
    {
        $requete=$BDD->prepare('UPDATE `offre` SET `offre_valide` = "1"  WHERE `offre_id` = ?;'
                . 'UPDATE `offre` SET `offre_signalee` = "0"  WHERE `offre_id` = ?;');
        $requete->execute(array($_POST["offre"],$_POST["offre"]));
        $offre=$requete->fetch();
    }
?>