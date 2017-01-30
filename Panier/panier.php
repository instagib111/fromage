<?php 
$cookBl = (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null);

if (isset($_COOKIE['panier'])) {
	$arrPanier = unserialize($_COOKIE['panier']);
} else {
	$arrPanier = array();
}

//vérification du formulaire de topArticle
if(isset($_POST['idFromage']) && isset($_POST['quantite']) && isset($_POST['poids']) && isset($_POST['prixTTC'])){
	if ($cookBl) { // si le cookie['panier'] existe
		$data = unserialize($_COOKIE['panier']);
		$id = (int) $_POST['idFromage'];
		$quantite = $_POST['quantite'];
		$poids = $_POST['poids'];
		$prix = $_POST['prixTTC'];
		if(array_key_exists($id, $data)){ // si on trouve l'id du fromage déjà existant

			$arrArticle = array(
					'idFromage' => $id,
					'nom' 		=> $_POST['nom'],
					'image' 	=> $_POST['image'],
					'quantite' 	=> $quantite += $data[$id]['quantite'],
					'poids' 	=> $poids,
					'prix' 		=> $prix
				 );
			$arrPanier[$id] = $arrArticle;
		} else {
			$arrArticle = array(
					'idFromage' => $id,
					'nom' 		=> $_POST['nom'],
					'image' 	=> $_POST['image'],
					'quantite' 	=> $quantite,
					'poids' 	=> $poids,
					'prix' 		=> $prix
				 );
			$arrPanier[$id] = $arrArticle;
		}


	}
	else { // s'il n'existe pas

		$arrArticle = array(
				'idFromage' => (int) $_POST['idFromage'],
				'nom' 		=> $_POST['nom'],
				'image' 	=> $_POST['image'],
				'quantite' 	=> $_POST['quantite'],
				'poids' 	=> $_POST['poids'],
				'prix' 		=> $_POST['prixTTC']
			 );

		$arrPanier[(int) $_POST['idFromage']] = $arrArticle;
	}
}


setcookie('panier', serialize($arrPanier), time() + 14*24*3600, "/");
		/*// intégration des données dans un array
		$arrArticle = array(
						'idFromage' => $_POST['idFromage'],
						'quantite' => $_POST['quantite'],
						'poids' => $_POST['poids'],
						'prix' => $_POST['prixTTC']
					 );
		// ajout du tableau de mes articles dans le tableau du panier
		array_push($arrPanier, $arrArticle);*/
//true ou false 
//array_key_exists(1, $arrPanier);

header('Location: ../index');
die();
?>