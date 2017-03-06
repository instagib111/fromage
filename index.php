<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("admin/connexionBDD.php"); ?>
<body>
	<?php include('header.php');

	$donnees = $conn->prepare("SELECT * FROM produits");
	$donnees->execute();
	$res = $donnees->fetchAll();


	//condition pour afficher ou non le slider
	$isIdFroSet = false;
	if (isset($_GET['id'])) {
		$idFro = $_GET['id'];
		$isIdFroSet = true;
		$idTemp = $_GET['id'] - 1;
		include('topArticle.php');
	} else {include('slider.php');}

	include("aside.php");

	//AFFICHAGE DES PRODUITS
	?>
		<section id="secArticle" class="row">
			<div class="col-xs-12 col-md-push-1 col-md-10 col-lg-push-2 col-lg-8">
				<div class="allArticles col-xs-12">
					<?php

					foreach ($res as $key => $value) {
						$produit = "<article class='articles col-md-4 col-sm-6 col-xs-12' data-valeur='". $value['id_fromage'] ."'>
									<div class='childArticles'>
									<img class='img_expo' src='" . $value['image'] . "' alt='". $value["nom"] ."' />";
						$produit .= "<div class='nomPrix col-xs-12'><h2 class='nomfrom col-xs-9'>". $value['nom'] ."</h2>
									<div class='prix col-xs-3'>". number_format($value['prixKg'], 2) ." €/Kg</div></div>";
						$produit .= "</div></article>";

						//var_dump($cat == $value['categorie']);
						//si on a un POST on regarde le param
						if($isIdFroSet){
							//si ça match on n'affiche pas le produit dans la liste
							if($idFro == $value['id_fromage']){/* rien */}
							else if($value['supp']) {/* rien */}
							else if($cat == $value['categorie']){echo $produit;}

						// on affiche tous les produits par default
						} else {
							if($value['supp']) {/* rien */}
							else if($cat == $value['categorie']){echo $produit;}
						}
					}
					?>
				</div>
			</div>
		</section>
		<form id="hidenForm" action="" method="GET">
			<input id="hidenAttr" name="id" type="hidden">
		</form>
	<?php include_once("footer.php"); ?>
	<script src="cont/js/funct.js"></script>
</body>
</html>
