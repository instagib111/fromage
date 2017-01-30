<?php 
$id = $_POST['idRetirer'];
$cook = unserialize($_COOKIE['panier']);

if (array_key_exists($id, $cook)){
	unset($cook[$id]);
	setcookie('panier', serialize($cook), time() + 14*24*3600, '/');

	if(sizeof($cook) == 0){
		$cook = null;
		setcookie('panier', null, time()-1, '/');
	}
}

header('Location: ../index');
die();
?>
