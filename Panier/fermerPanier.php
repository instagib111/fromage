<?php 
setcookie('panier', null, time() - 1, '/');
header('Location: ../index');
die();
?>
