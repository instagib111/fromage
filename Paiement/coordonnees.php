<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php'); ?>


<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null){ // si le cookie existe 
	include("headerPanier.php");?>

	<?php if ((isset($_POST['confirmation']) && $_POST['confirmation'] == "confirm") || ($_SESSION["unconfirm"] >= 1) || (isset($_POST["prec"]))) { // vérification si je viens bien de la page recap.php ou je viens de la page paiement 
		
		if(isset($_SESSION["unconfirm"]) && $_SESSION["unconfirm"] == 2)//si je n'ai pas une égalité entre les deux email
			echo '<form id="formu"><div><h3>Vous avez mentionné deux emails différent.</h3></div></form>';

		$_SESSION["unconfirm"] = 0;?>
	<form id="formu" action="paiement" method="post">
	<!-- si le client est une société ou non

		<label for="societe">Societe :</label>
		<input type="text" name="societe" id="societe" />
	-->
		<div>
			<h3>Infos Personnelles</h3>
			<label for="nom">Nom : </label>
			<input type="text" name="nom" id="nom" value="<?php if(isset($_SESSION['nom']))echo $_SESSION['nom']; ?>" required /><br />
			<label for="prenom">Prénom : </label>
			<input type="text" name="prenom" id="prenom" value="<?php if(isset($_SESSION['prenom']))echo $_SESSION['prenom']; ?>" required /><br />
			<label for="email">E-mail : </label>
			<input type="email" name="email" id="email" value="<?php if(isset($_SESSION['email']))echo $_SESSION['email']; ?>" required /><br />
			<label for="confirm">Confirmer votre E-mail :</label>
			<input type="email" id="confirm" name="confirm" required /> <span id="confirmResultat"></span><br />
		</div>
		
		<div> 
			<label for="same">Mon adresse de facturation est la même que celle de livraison :</label>
			<input type="radio" id="same" name="same" value="same" checked="checked" /><br />
			<label for="notsame">Mon adresse de facturation n'est pas la même que celle de livraison :</label>
			<input type="radio" id="notsame" name="same" value="notsame" /><br />
		</div>
	
		<div id="adresseFacturation">
			<h3>Adresse de facturation</h3>
			<label for="adresseF">Adresse :</label>
			<input type="text" id="adresseF" name="adresseF" value="<?php if(isset($_SESSION['adresseF']))echo $_SESSION['adresseF']; ?>" required /><br />
			<label for="villeF">Ville :</label>
			<input type="text" id="villeF" name="villeF" value="<?php if(isset($_SESSION['villeF']))echo $_SESSION['villeF']; ?>" required /><br />
			<label for="codePostalF">Code Postal :</label>
			<input type="text" id="codePostalF" name="codePostalF" value="<?php if(isset($_SESSION['codePostalF']))echo $_SESSION['codePostalF']; ?>" required /><br />
			<label for="paysF">Pays :</label>
			<input type="text" id="paysF" name="paysF" value="<?php if(isset($_SESSION['paysF']))echo $_SESSION['paysF']; ?>" required /><span id="paysResultat"></span><br />
		</div>
		<div id="adresseLivraison">
			<h3>Adresse de livraison</h3>
			<label for="adresseL">Adresse :</label>
			<input type="text" id="adresseL" name="adresseL" value="<?php if(isset($_SESSION['adresseL']))echo $_SESSION['adresseL']; ?>" /><br />
			<label for="villeL">Ville :</label>
			<input type="text" id="villeL" name="villeL" value="<?php if(isset($_SESSION['villeF']))echo $_SESSION['villeF']; ?>" /><br />
			<label for="codePostalL">Code Postal :</label>
			<input type="text" id="codePostalL" name="codePostalL" value="<?php if(isset($_SESSION['codePostalF']))echo $_SESSION['codePostalF']; ?>" /><br />
			<label for="paysL">Pays :</label>
			<input type="text" id="paysL" name="paysL" value="<?php if(isset($_SESSION['paysF']))echo $_SESSION['paysF']; ?>" /><span id="paysResultat"></span><br />
		</div>

		<button id="btn_suivant" name="next" >ETAPE SUIVANTE</button>
	</form>
	<form id="before" action="recap" methode="post">
		<button id="btn_precedent">ETAPE PRECEDENTE</button>
	</form>
	<?php }//end if ?>

<?php } //end if 
	else //si mon panier est null
		echo '<script type="text/javascript">window.location = "../index";</script>';
include_once("../footer.php"); ?>
	<script src="../cont/js/funct.js"></script>
	<script>
		window.onload = function() {
			// retire le copy past de ce champs
			var myInput = document.getElementById('confirm');
			myInput.onpaste = function(e) {
				e.preventDefault();
			}
			$("#adresseFacturation").show();
			$("#adresseLivraison").hide();
		}
	</script>
</body>
</html>