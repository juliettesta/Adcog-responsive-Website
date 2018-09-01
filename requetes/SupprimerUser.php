<?php
    require("../db/connect.php");
    if (isset ($_POST["id"]))
    {
        $requete=$BDD->prepare('DELETE FROM liaison_panier WHERE utilisateur_id=?;'
                . 'DELETE FROM utilisateur WHERE utilisateur_id=?;');
        $requete->execute(array($_POST["id"],$_POST["id"]));

}
?>