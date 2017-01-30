<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php'); ?>


<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null) { // si le cookie existe
	include("headerPanier.php");?>

	<section id="panier">
		<h3>VOTRE PANIER</h3>
	<?php $cookie = unserialize($_COOKIE['panier']);
	$total = 0;
	$poids = 0;
	foreach ($cookie as $key => $value) {
	?>
		<div class="dPanier" data-id="<?php echo $value['idFromage']; ?>">
			<h4><?php echo $value['nom']; ?></h4>
			<form action="../Panier/retirer" method="post">
				<input type="hidden" name="idRetirer" value="<?php echo $value['idFromage']; ?>" />
				<button id="btnRetirerPanier" class="glyphicon glyphicon-remove"></button>
			</form>
			<img class="imgPan" src="<?php echo $value['image']; ?>" alt="<?php echo $value['nom']; ?>" />
			<div> 
				<span>Quantite :<span class="quantitePanier"><?php echo $value['quantite']; ?></span></span>
				<span>Poids/u :<span class="poidsPanier"><?php echo $value['poids'] * 1000; ?>g</span></span>
				<span>Prix :<span class="prixPanier"><?php echo $value['prix']; ?>€</span></span>
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
		<form action="Panier/fermerPanier">
			<button id="btnEffacerPanier">EFFACER PANIER</button>
		</form>
		<div class="Totaux">
			<span>Poids Total: <span id="poidsTotal"><?php echo $_SESSION['poidsTotal'] = $poids; ?>g</span></span>
			<span>Prix livraison: <span id="prixLivraison"><?php echo $_SESSION['prixLivraison'] = number_format($prixLivraison, 2); ?>€</span></span>
			<span>Prix Total: <span id="prixTotal"><?php echo $_SESSION['prixTotal'] = number_format($total, 2); ?>€</span></span>
		</div>
		<form action="coordonnees" method="post">
			<input type="hidden" name="confirmation" value="confirm" />
			<button id="next" >ETAPE SUIVANTE</button>
		</form>
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