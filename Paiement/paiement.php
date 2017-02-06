<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php');

if (empty($_POST["nom"]) || ctype_space($_POST["nom"]) ||
		empty($_POST["prenom"]) || ctype_space($_POST["prenom"]) ||
		empty($_POST["email"]) || ctype_space($_POST["email"]) ||
		empty($_POST["confirm"]) || ctype_space($_POST["confirm"]) ||
		empty($_POST["adresseF"]) || ctype_space($_POST["adresseF"]) ||
		empty($_POST["villeF"]) || ctype_space($_POST["villeF"]) ||
		empty($_POST["codePostalF"]) || ctype_space($_POST["codePostalF"]) ||
		empty($_POST["paysF"]) || ctype_space($_POST["paysF"]) ) {
			$_SESSION["unconfirm"] = 3;
			header('Location: ../Paiement/coordonnees');
			die();
		}

if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null ) { // si le cookie existe
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
		header('Location: ../Paiement/coordonnees');
		die();
	} else { //sinon ?>
		<div id="infos" class="row">
			<div class="diCoor col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
				<h3 class="col-xs-12 tac">Infos Personnelles</h3>
				<span class="col-xs-6">Nom : </span><span class="col-xs-6"><?php echo $_SESSION["nom"] = $_POST["nom"]; ?></span>
				<span class="col-xs-6">Prénom : </span><span class="col-xs-6"><?php echo $_SESSION["prenom"] = $_POST["prenom"]; ?></span>
				<span class="col-xs-6">Email : </span><span class="col-xs-6"><?php echo $_SESSION["email"] = $_POST["email"]; ?></span>

				<h3 class="col-xs-12 tac">Adresse de <?php echo $_POST["same"] == "same" ? "livraison et de facturation" : "facturation" ?></h3>
				<span class="col-xs-6">Adresse : </span><span class="col-xs-6"><?php echo $_SESSION["adresseF"] = $_POST["adresseF"]; ?></span>
				<span class="col-xs-6">Code Postal: </span><span class="col-xs-6"><?php echo $_SESSION["codePostalF"] = $_POST["codePostalF"]; ?></span>
				<span class="col-xs-6">Ville : </span><span class="col-xs-6"><?php echo $_SESSION["villeF"] = $_POST["villeF"]; ?></span>
				<span class="col-xs-6">Pays : </span><span class="col-xs-6"><?php echo $_SESSION["paysF"] = $_POST["paysF"]; ?></span>
				<?php if($_POST["same"] == "notsame"){ ?>
				<h3 class="col-xs-12 tac">Adresse de livraison</h3>
				<span class="col-xs-6">Adresse : </span><span class="col-xs-6"><?php echo $_SESSION["adresseL"] = $_POST["adresseL"]; ?></span>
				<span class="col-xs-6">Code Postal: </span><span class="col-xs-6"><?php echo $_SESSION["codePostalL"] = $_POST["codePostalL"]; ?></span>
				<span class="col-xs-6">Ville : </span><span class="col-xs-6"><?php echo $_SESSION["villeL"] = $_POST["villeL"]; ?></span>
				<span class="col-xs-6">Pays : </span><span class="col-xs-6"><?php echo $_SESSION["paysL"] = $_POST["paysL"]; ?></span>
				<?php } else if($_POST["same"] == "same"){
					$_SESSION["adresseL"] = $_POST["adresseF"];
					$_SESSION["codePostalL"] = $_POST["codePostalF"];
					$_SESSION["villeL"] = $_POST["villeF"];
					$_SESSION["paysL"] = $_POST["paysF"];
				} ?>
				<span class="col-xs-6">Prix Total TTC: </span><span class="col-xs-6"><?php echo number_format($_SESSION["prixTotal"], 2); ?> €</span>
			</div>
		</div>
		<div class="btnPai row">
			<form id="before" class="col-xs-12 col-sm-6 tac" action="coordonnees" methode="post">
				<button class="btn btn-warning" name="prec" type="submit" value="1">ETAPE PRECEDENTE</button>
			</form>
			<form id="paypal" class="col-xs-12 col-sm-6 tac" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
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

				<button class="btn btn-success">Payer avec PayPal</button>
			</form>
		</div>


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
