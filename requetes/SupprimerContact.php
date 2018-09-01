<?php
    require("../db/connect.php");
    if (isset ($_POST["contact"]))
    {
        $requete=$BDD->prepare('DELETE FROM contact WHERE contact_id=?;');
        $requete->execute(array($_POST["contact"]));

}
?>