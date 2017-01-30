<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php") ?>
<body>
<?php include_once("../header.php") ?>
<?php

require_once("connexionBDD.php");
//déconnection
$_SESSION["admin"] = false;



// si je ne suis pas connecté, je suis renvoyé vers la page d'acceuil.
if(!$_SESSION["admin"]){
	echo '<script type="text/javascript">window.location = "connexionAdmin.php?deco=un";</script>';
}

include_once("../footer.php") ?>
</body>
</html>
