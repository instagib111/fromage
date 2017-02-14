<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<?php require_once("../admin/connexionBDD.php"); ?>
<body>
<?php include('../header.php'); ?>


<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null){ // si le cookie existe
	include("headerPanier.php");?>

	<?php if ((isset($_POST['confirmation']) && $_POST['confirmation'] == "confirm") || ($_SESSION["unconfirm"] >= 1) || (isset($_POST["prec"]))) { // vérification si je viens bien de la page recap.php ou je viens de la page paiement

		if(isset($_SESSION["unconfirm"])){
			if($_SESSION["unconfirm"] == 2)//si je n'ai pas une égalité entre les deux email
				echo '<div><h3 id="errMsg" class="diCoorBtn col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">Vous avez mentionné deux E-mails différent.</h3></div>';
			else if($_SESSION["unconfirm"] == 3)
				echo '<div><h3 id="errMsg" class="diCoorBtn col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">Vous devez remplir tous les champs présenté.</h3></div>';
		}

		$_SESSION["unconfirm"] = 0;?>
	<form id="formu" class="row" action="paiement" method="post">
	<!-- si le client est une société ou non

		<label for="societe">Societe :</label>
		<input type="text" name="societe" id="societe" />
	-->
		<div class="diCoor col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<h3 class="infoCoor col-xs-12">Infos Personnelles</h3>
			<label class="m0 col-xs-6" for="nom">Nom* : </label>
			<input class="col-xs-6" type="text" name="nom" id="nom" value="<?php if(isset($_SESSION['nom']))echo $_SESSION['nom']; ?>" required />
			<label class="m0 col-xs-6" for="prenom">Prénom* : </label>
			<input class="col-xs-6" type="text" name="prenom" id="prenom" value="<?php if(isset($_SESSION['prenom']))echo $_SESSION['prenom']; ?>" required />
			<label class="m0 col-xs-6" for="email">E-mail* : </label>
			<input class="col-xs-6" type="email" name="email" id="email" value="<?php if(isset($_SESSION['email']))echo $_SESSION['email']; ?>" required />
			<label class="m0 col-xs-6" for="confirm">Confirme E-mail* :</label>
			<input class="col-xs-6" type="email" id="confirm" name="confirm" required /> <span id="confirmResultat"></span>
		</div>

		<div id="radioRow" class="diCoor col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<div class="radio col-xs-12 col-sm-offset-1 col-sm-5 col-md-offset-1 col-md-5">
				<label class="col-xs-11" for="same">Mon adresse de facturation est la même que celle de livraison :</label>
				<input  class="col-xs-1" type="radio" id="same" name="same" value="same" checked="checked" />
			</div>
			<div class="radio col-xs-12 col-sm-offset-1 col-sm-5 col-md-offset-1 col-md-5">
				<label class="col-xs-11" for="notsame">Mon adresse de facturation n'est pas la même que celle de livraison :</label>
				<input  class="col-xs-1" type="radio" id="notsame" name="same" value="notsame" />
			</div>
		</div>

		<div id="adresseFacturation" class="diCoor col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<h3 class="infoCoor col-xs-12">Adresse de facturation</h3>
			<label class="m0 col-xs-6" for="adresseF">Adresse* :</label>
			<input class="col-xs-6" type="text" id="adresseF" name="adresseF" value="<?php if(isset($_SESSION['adresseF']))echo $_SESSION['adresseF']; ?>" required />
			<label class="m0 col-xs-6" for="villeF">Ville* :</label>
			<input class="col-xs-6" type="text" id="villeF" name="villeF" value="<?php if(isset($_SESSION['villeF']))echo $_SESSION['villeF']; ?>" required />
			<label class="m0 col-xs-6" for="codePostalF">Code Postal* :</label>
			<input class="col-xs-6" type="text" id="codePostalF" name="codePostalF" value="<?php if(isset($_SESSION['codePostalF']))echo $_SESSION['codePostalF']; ?>" required />
			<label class="m0 col-xs-6" for="paysF">Pays* :</label>
			<input class="col-xs-6" type="text" id="paysF" name="paysF" value="<?php if(isset($_SESSION['paysF']))echo $_SESSION['paysF']; ?>" required /><span id="paysResultat"></span>
		</div>
		<div id="adresseLivraison" class="diCoor col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<h3 class="infoCoor col-xs-12">Adresse de livraison</h3>
			<label class="m0 col-xs-6" for="adresseL">Adresse :</label>
			<input class="col-xs-6" type="text" id="adresseL" name="adresseL" value="<?php if(isset($_SESSION['adresseL']))echo $_SESSION['adresseL']; ?>" />
			<label class="m0 col-xs-6" for="villeL">Ville :</label>
			<input class="col-xs-6" type="text" id="villeL" name="villeL" value="<?php if(isset($_SESSION['villeF']))echo $_SESSION['villeF']; ?>" />
			<label class="m0 col-xs-6" for="codePostalL">Code Postal :</label>
			<input class="col-xs-6" type="text" id="codePostalL" name="codePostalL" value="<?php if(isset($_SESSION['codePostalF']))echo $_SESSION['codePostalF']; ?>" />
			<label class="m0 col-xs-6" for="paysL">Pays :</label>
			<input class="col-xs-6" type="text" id="paysL" name="paysL" value="<?php if(isset($_SESSION['paysF']))echo $_SESSION['paysF']; ?>" /><span id="paysResultat"></span>
		</div>
		<input type="hidden" name="next" value="" />
	</form>
	<form id="before" action="recap" methode="post">
	</form>
	<div class="btnPai row">
		<div class="diCoorBtn col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
			<div class="col-xs-12">
				<div class="col-xs-12 col-sm-6 tac">
					<button id="btn_precedent" class="btn btn-warning" onclick="subBefore()">ETAPE PRECEDENTE</button>
				</div>
				<div class="col-xs-12 col-sm-6 tac">
					<button id="btn_suivant" class="btn btn-success" onclick="subFormu()">ETAPE SUIVANTE</button>
				</div>
			</div>
		</div>
	</div>
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
		function subFormu(){
			$("#formu").submit();
		}
		function subBefore (){
			$("#before").submit();
		}
	</script>
</body>
</html>
