<?php
    require("../db/connect.php");
    if (isset ($_POST["offre"]))
    {
        $requete=$BDD->prepare('UPDATE `offre` SET `offre_signalee` = "0"  WHERE `offre_id` = ?;');
        $requete->execute(array($_POST["offre"]));
        $offre=$requete->fetch();
    }
?>