<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php'); ?>


<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null) { // si le cookie existe
	include("headerPanier.php");?>

	<section id="secRecap" class="row">
		<div id="panier" class="col-xs-12 col-md-push-1 col-md-10 col-lg-push-2 col-lg-8">
			<div class="recap col-xs-12">
		<h3 id="lblTitrePanier">VOTRE PANIER</h3>
	<?php $cookie = unserialize($_COOKIE['panier']);
	$total = 0;
	$poids = 0;
	foreach ($cookie as $key => $value) {
	?>
		<div class="dPanier col-xs-12 col-sm-6" data-id="<?php echo $value['idFromage']; ?>">
			<div class="childDPanier col-xs-12">
				<h4 class="lblTitreProduitPanier col-xs-12"><?php echo $value['nom']; ?>
					<form class="btnDelete" action="../Panier/retirer" method="post">
						<input type="hidden" name="idRetirer" value="<?php echo $value['idFromage']; ?>" />
						<button id="btnRetirerPanier" class="btn btn-warning glyphicon glyphicon-remove"></button>
					</form>
				</h4>
				<div class="col-xs-6">
					<img class="imgPan" src="<?php echo $value['image']; ?>" alt="<?php echo $value['nom']; ?>" />
				</div>
				<div class="infos col-xs-6">
					<span class="col-xs-9">Quantite :</span><span class="quantitePanier tar p0 col-xs-3"><?php echo $value['quantite']; ?></span>
					<span class="col-xs-9">Poids/u :</span><span class="poidsPanier tar p0 col-xs-3"><?php echo $value['poids'] * 1000; ?>g</span>
					<span class="col-xs-9">Prix :</span><span class="prixPanier tar p0 col-xs-3"><?php echo $value['prix']; ?>€</span>
				</div>
			</div>
		</div>
	<?php 	$total += $value['prix'];
			$poids += $value['poids'] * 1000 * $value['quantite'];
			$tpoids = $poids;
	} //end foreach
	$hoverCount = 0;
	while($tpoids >= 30000){// si j'entre dans la boucle, alors le tpoids est supèrieur à 30 000g (si je suis supérieur à 30 000g, la BDD ne renvoit rien )
		$hoverCount++;
		$tpoids -= 30000;
	}

	//préparation de la BDD pour l'affichage du prix de la livraison
	$donnees = $conn->prepare("SELECT prix FROM colissimo WHERE g > " . $tpoids . " ORDER BY id_colis DESC"); //récupère les prix des fromages par rapport au poids
	$donnees->execute();
	$res = $donnees->fetchAll();

	$d = $conn->prepare("SELECT prix FROM colissimo WHERE g = NULL"); //récupère les prix sur avis de réception et emballage affranchi
	$d->execute();
	$r = $d->fetchAll();

	foreach ($res as $key => $value) {
		$prixLivraison = $value[0];
	}
	while($hoverCount != 0){
		$hoverCount--;
		$prixLivraison += 26.50; //le prix d'une livraison de 30 000g
	}
	foreach ($r as $key => $value) {
		$prixLivraison += $value[0];
	}

	$total += $prixLivraison;

	?>
		<div class="infoPan col-xs-12">
			<form class="col-xs-12 col-sm-4" action="Panier/fermerPanier">
				<button id="btnEffacerPanier" class="btn btn-warning">EFFACER PANIER</button>
			</form>
			<div class="col-xs-6 col-xs-offset-3 col-sm-offset-0 col-sm-4 Totaux">
				<span class="col-xs-9 tal">Poids Total: </span><span id="poidsTotal" class="tar p0 col-xs-3"><?php echo $_SESSION['poidsTotal'] = $poids; ?>g</span>
				<span class="col-xs-9 tal">Prix livraison: </span><span id="prixLivraison"  class="tar p0 col-xs-3"><?php echo $_SESSION['prixLivraison'] = number_format($prixLivraison, 2); ?>€</span>
				<span class="col-xs-9 tal">Prix Total: </span><span id="prixTotal" class="tar p0 col-xs-3"><?php echo $_SESSION['prixTotal'] = number_format($total, 2); ?>€</span>
			</div>
			<form class="col-xs-12 col-sm-4" action="coordonnees" method="post">
				<input type="hidden" name="confirmation" value="confirm" />
				<button class="btn btn-success" id="next" >ETAPE SUIVANTE</button>
			</form>
		</div>
	</div>
	</div>
	</section>
<?php } // end if
else {?>
	<section id="panier">
			<h3> VOTRE PANIER EST VIDE </h3>
	</section>
<?php } //end else ?>

<form id="hidenForm" action="../index" method="post">
	<input id="hidenAttr" name="id" type="hidden">
</form>
<?php include_once("../footer.php"); ?>
	<script src="../cont/js/funct.js"></script>
</body>
</html>
