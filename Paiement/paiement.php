<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php'); ?>


<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null ) { // si le cookie existe
	if(!isset($_POST["next"])){
		header('Location: ../index');
		die();
	}
	include("headerPanier.php");?>
	<?php foreach ($_POST as $key => $value) {
		$_SESSION[$key] = $value;
		//echo "<div id='".$key."' class='donnees'>".$value."</div>";
	}
	$_SESSION["unconfirm"] = 1;
	if($_SESSION["email"] != $_SESSION["confirm"]){// si la confirmation d'email est fausse
		$_SESSION["unconfirm"] = 2;
		echo '<script type="text/javascript">window.location = "../Paiement/coordonnees";</script>';
	} else { //sinon ?>
		<div id="infos">
			<h3>Infos Personnelles</h3>
			Nom : <?php echo $_SESSION["nom"] = $_POST["nom"]; ?><br />
			Prénom : <?php echo $_SESSION["prenom"] = $_POST["prenom"]; ?><br />
			Email : <?php echo $_SESSION["email"] = $_POST["email"]; ?><br />

			<h3>Adresse de <?php echo $_POST["same"] == "same" ? "livraison et de facturation" : "facturation" ?></h3>
			Adresse : <?php echo $_SESSION["adresseF"] = $_POST["adresseF"]; ?><br />
			Code Postal: <?php echo $_SESSION["codePostalF"] = $_POST["codePostalF"]; ?><br />
			Ville : <?php echo $_SESSION["villeF"] = $_POST["villeF"]; ?><br />
			Pays : <?php echo $_SESSION["paysF"] = $_POST["paysF"]; ?><br /><br />
			<?php if($_POST["same"] == "notsame"){ ?>
			<h3>Adresse de livraison</h3>
			Adresse : <?php echo $_SESSION["adresseL"] = $_POST["adresseL"]; ?><br />
			Code Postal: <?php echo $_SESSION["codePostalL"] = $_POST["codePostalL"]; ?><br />
			Ville : <?php echo $_SESSION["villeL"] = $_POST["villeL"]; ?><br />
			Pays : <?php echo $_SESSION["paysL"] = $_POST["paysL"]; ?><br /><br />
			<?php } else if($_POST["same"] == "same"){
				$_SESSION["adresseL"] = $_POST["adresseF"];
				$_SESSION["codePostalL"] = $_POST["codePostalF"];
				$_SESSION["villeL"] = $_POST["villeF"];
				$_SESSION["paysL"] = $_POST["paysF"];
			} ?>
			Prix Total TTC: <?php echo number_format($_SESSION["prixTotal"], 2); ?> €
		</div>

	<form id="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<input name="cmd" type="hidden" value="_xclick" />
		<input name="amount" type="hidden" value="<?php echo $_SESSION['prixTotal'] ?>" />
		<input name="currency_code" type="hidden" value="EUR" />
		<input name="shipping" type="hidden" value="0.00" />
		<input name="return" type="hidden" value="<?php echo $BASE_URL ?>Paiement/confPaypal" /><!-- si bien payé -->
		<input name="cancel_return" type="hidden" value="<?php echo $BASE_URL ?>" /> <!-- si cancel-->
		<input name="business" type="hidden" value="achard.christopher-facilitator@gmail.com" />
		<input name="item_name" type="hidden" value="Votre panier" />
		<input name="lc" type="hidden" value="FR" />
		<input type="hidden" name="address1" value="<?php echo $_SESSION["adresseL"]; ?>" />
		<input type="hidden" name="city" value="<?php echo $_SESSION["villeL"]; ?>" />
		<input type="hidden" name="state" value="<?php echo $_SESSION["paysL"]; ?>">
		<input type="hidden" name="zip" value="<?php echo $_SESSION["codePostalL"]; ?>">
		<input type="hidden" name="email" value="<?php echo $_POST["email"]; ?>">
		<input name="first_name" type="hidden" value="<?php echo $_POST["prenom"]; ?>">
		<input name="last_name" type="hidden" value="<?php echo $_POST["nom"]; ?>">
		<input type='hidden' name='bn' value='PP-BuyNowBF'>

		<button>Payer avec PayPal</button>
	</form>
	<form id="before" action="coordonnees" methode="post">
		<button name="prec" type="submit" value="1">ETAPE PRECEDENTE</button>
	</form>


<?php }//end else
	} //end if
	else {
		header('Location: ../index');
	die();
}
include_once("../footer.php"); ?>
	<script src="../cont/js/funct.js"></script>
</body>
</html>
