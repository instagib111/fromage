<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<body>
<?php include_once("../header.php");
//connexion var $conn
require_once("connexionBDD.php");

// si je ne suis pas connecté, je suis renvoyé vers la page de connexion.
if(!$_SESSION["admin"]){
	header('Location: connexionAdmin');
	die();
}
	if(isset($_POST['idCommande']) && isset($_POST['statut']) && ($_POST['btn'] == 1)){
		$id = $_POST['idCommande'];

		if($_POST['statut'] == "0")
			$statut = 1;
		else if($_POST['statut'] == "1")
			$statut = 0;

		//Update
		$sql = "UPDATE commandes 
				SET statut = :statut,
					date_envoye = NOW()
				WHERE id_commande = :id_commande";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_commande', $id, PDO::PARAM_INT);
		$up->bindParam(':statut', $statut, PDO::PARAM_INT);
		$up->execute();
	}
	if(isset($_POST['idCommande']) && isset($_POST['statut']) && ($_POST['btn'] == 2)){
		$id = $_POST['idCommande'];

		if($_POST['statut'] == "1")
			$statut = 2;
		else if($_POST['statut'] == "2")
			$statut = 1;

		//Update
		$sql = "UPDATE commandes 
				SET statut = :statut,
					date_delivre = NOW()
				WHERE id_commande = :id_commande";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_commande', $id, PDO::PARAM_INT);
		$up->bindParam(':statut', $statut, PDO::PARAM_INT);
		$up->execute();
	}


	$d = $conn->prepare("SELECT * FROM commandes");
	$d->execute();
	$res = $d->fetchAll();
 ?>
 <div id="backOffice">
<form action="admin" methode="post">
	<button id="btn_produit" class="btn">Produit(s)</button>
</form>
	
<table id="data">
<thead>
	<tr>
		<th>ID</th><th>PANIER</th><th>NON</th><th>PRENOM</th><th>ADRESSE</th><th>PRIX</th><th>COMMANDE</th><th>ENVOYE</th><th>REÇUE</th>
	</tr>
</thead>
<tbody>	
	<?php 
	foreach ($res as $key => $value) { ?>
		<tr id='l<?php echo $value["id_commande"]; ?>' data-statut='<?php echo $value["statut"]; ?>' class='statut<?php echo $value["statut"]; ?>' >
		<?php 

			$panier = unserialize($value['panier']); 
			$unPanier = "PANIER\n";
			foreach ($panier as $cle => $var) {
				$unPanier .= "\n" . strtoupper($var["nom"]);
				$unPanier .= "\nQuantité :" . $var["quantite"];
				$unPanier .= "\nPoids :" . ($var["poids"] * 1000) ."g";
				$unPanier .= "\nPrix :" . $var["prix"] . "€\n";
			}
			$adresse = unserialize($value['adresse']);
			$unAdresse =  "FACTURATION\nAdresse: ".$adresse['adresseF']."\nCode Postal: " . $adresse['cpF'] . "\nVille : ". $adresse['villeF'];
			$unAdresse .= "\n\nLIVRAISON\nAdresse: ".$adresse['adresseL']."\nCode Postal: " . $adresse['cpL'] . "\nVille : ". $adresse['villeL'];

			for ($i = 0; $i < sizeof($value)/2; $i++) {
				//echo "<td>". $value[$i] ."</td>";
				if ($i == 0) echo "<td>". $value[$i] ."</td>"; // ID
				else if($i == 1) echo "<td><button class='btn_affPan' data-panier='".$unPanier."'>AFFICHER</button></td>"; // PANIER
				else if($i == 4) echo "<td><button class='btn_affAdr' data-adresse='". $unAdresse ."'>AFFICHER</button></td>"; // ADRESSE
				else if($i == 5) echo "<td>".$value[$i]."€</td>"; //PRIX
				else if($i == 6) { // COMMANDE
					$date = DateTime::createFromFormat('Y-m-d H:i:s', $value["date_commande"]); 
					echo "<td>". $date->format('d/m/y H:i') . "</td>";
					}
				else if($i == 7) {//date ENVOYE statut0 = pas envoyé
					$dateE = DateTime::createFromFormat('Y-m-d', $value["date_envoye"]); 
					echo "<td><button data-id='".$value['id_commande']."' class='btn_envoye'>". ($value[9] != 0 ? $dateE->format('d/m/Y') : "ENVOYER") . "</button></td>";
					} 
				else if($i == 8) { //date RECUE statut2 = reçue
					$dateR = DateTime::createFromFormat('Y-m-d', $value["date_delivre"]); 
					echo "<td><button data-id='".$value['id_commande']."' class='btn_recue'>". ($value[9] != 2 ? "REÇUE" : $dateR->format('d/m/Y')) . "</button></td>";
					} 
				else if($i == 9) echo ""; // STATUT 'ne doit pas etre visible'
				else echo "<td>". $value[$i] ."</td>"; // AUTRES
			} ?>
		</tr>
	<?php }
	?>
</tbody>
</table>


<div id="end">
	<a href="deco" class="btnDeco">Déconnexion</a>
</div>

<?php include_once("../footer.php") ?>
<script src="../cont/js/funct.js"></script>
</body>
</html>