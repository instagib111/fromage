<?php require_once("connexionBDD.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<?php include_once("head.php"); ?>
<body>
<?php include_once("../header.php");
// si je ne suis pas connecté, je suis renvoyé vers la page de connexion.
if(!$_SESSION["admin"]){
	header('Location: connexionAdmin');
	die();
}

//préparation de la BDD pour le traitement
$d = $conn->prepare("SELECT * FROM produits");
$d->execute();
$resD = $d->fetchAll();

// MODIFICATION D'UNE LIGNE
if(isset($_POST['id_fromage'])) {
	$id = (int)$_POST['id_fromage'];
	
	//Update
	$sql = "UPDATE produits 
			SET nom = :nom,
				categorie = :categorie,
				prixKg = :prixKg,
				description = :description,
				image = :image 
			WHERE id_fromage = :id_fromage";
	$up = $conn->prepare($sql);
	$up->bindParam(':id_fromage', $id, PDO::PARAM_INT);
	$up->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
	$up->bindParam(':categorie', $_POST['categorie'], PDO::PARAM_STR);
	$up->bindParam(':prixKg', $_POST['prixKg'], PDO::PARAM_STR);
	$up->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
	$up->bindParam(':image', $_POST['image'], PDO::PARAM_STR);
	$up->execute();
	
}

//AJOUT D'UNE LIGNE
if(isset($_POST['id_fromage']) && $_POST['id_fromage'] == ""){
	$sql = "INSERT INTO produits(nom,categorie,prixKg,description,image)
			VALUES (:nom,:categorie,:prixKg,:description,:image)";
	$up = $conn->prepare($sql);
	$up->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
	$up->bindParam(':categorie', $_POST['categorie'], PDO::PARAM_STR);
	$up->bindParam(':prixKg', $_POST['prixKg'], PDO::PARAM_STR);
	$up->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
	$up->bindParam(':image', $_POST['image'], PDO::PARAM_STR);
	$up->execute();
}

//SUPPRESSION D'UNE LIGNE (ARCHIVE AVEC UPDATE) || RETABLIR
if(isset($_POST['idSupp']) && isset($_POST['stat'])){
	$id = (int) $_POST['idSupp'];
	if($_POST['stat'] == 0){
		//Update pour supprimer
		$sql = "UPDATE produits 
				SET supp = :supp 
				WHERE id_fromage = :id_fromage";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_fromage', $id, PDO::PARAM_INT);
		$up->bindValue(':supp', 1, PDO::PARAM_BOOL);
		$up->execute();
	}
	if($_POST['stat'] == 1){
		//Update pour rétablir
		$sql = "UPDATE produits 
				SET supp = :supp 
				WHERE id_fromage = :id_fromage";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_fromage', $id, PDO::PARAM_INT);
		$up->bindValue(':supp', 0, PDO::PARAM_BOOL);
		$up->execute();
	}
}
//AFFICHAGE SUR LE SLIDER 
if(isset($_POST['idSlider']) && isset($_POST['stat'])){
	$id = $_POST['idSlider'];
		if($_POST['stat'] == 0){
		//Update pour supprimer
		$sql = "UPDATE produits 
				SET slider = :slider 
				WHERE id_fromage = :id_fromage";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_fromage', $id, PDO::PARAM_INT);
		$up->bindValue(':slider', 1, PDO::PARAM_BOOL);
		$up->execute();
	}
	if($_POST['stat'] == 1){
		//Update pour rétablir
		$sql = "UPDATE produits 
				SET slider = :slider 
				WHERE id_fromage = :id_fromage";
		$up = $conn->prepare($sql);
		$up->bindParam(':id_fromage', $id, PDO::PARAM_INT);
		$up->bindValue(':slider', 0, PDO::PARAM_BOOL);
		$up->execute();
	}
}

//préparation de la BDD pour l'affichage
$donnees = $conn->prepare("SELECT * FROM produits");
$donnees->execute();
$res = $donnees->fetchAll();

//AFICHAGE DE LA BDD ?>
<div id="backOffice">
	
<form action="commandes" methode="post">
	<button id="btn_commande" class="btn">Commande(s)</button>
</form>

<table id="data">
<thead>
	<tr>
		<th>ID</th><th>NOM</th><th>CATEGORIE</th><th>PRIX</th><th>DESCRIPTION</th><th>IMAGE</th><th>SLIDER</th><th>MODIF.</th><th>SUPP.</th>
	</tr>
</thead>
<tbody>	
	<?php 
	foreach ($res as $key => $value) {
		echo "<tr id='l".$value['id_fromage']."' class='status".$value['supp']."'>";
		for ($i=0; $i < sizeof($value)/2 ; $i++) {
			if($i == 5) {echo "<td><img src='".$value[$i]."' alt='Image' style='width:50px; height:50px;'></td>";}//affichage de l'image
			else if ($i == 3){echo "<td>". $value[$i] ."€</td>";} //affichage du prix
			else if ($i == 4){echo "<td class='descri'>". $value[$i] ."</td>";}	// affichage description
			else if ($i == 6){/*rien*/} // affichage du status
			else if ($i == 7){echo "<td><button class='btn_slider' data-stat='".$value[$i]."' data-id='".$value['id_fromage']."'>". ($value[$i] == 1 ? "OUI" : "NON") ."</button></td>";} // bool pour afficher le produit dans le slider ou non slider
			else {echo "<td>". $value[$i] ."</td>";}// affichage du reste
				
		}
		$dataValeur = '{"id_fromage" : "'.$value['id_fromage'].'","nom" : "'.str_replace("'", "’",$value['nom']).'","categorie" : "'.str_replace("'", "’",$value['categorie']).'","prixKg" : "'.str_replace(",", ".",$value['prixKg']).'","description" : "'.str_replace("'", "’",$value['description']).'","image" : "'.$value['image'].'" }';

		echo '<td><span class="lnkModifier glyphicon glyphicon-pencil" data-valeur=\''.$dataValeur.'\'></span></td>';
		if(!$value['supp'])/* si status est à 0 */
			{echo '<td><span class="lnkSuppReta glyphicon glyphicon-remove" data-stat="0" data-valeur="'.$value['id_fromage'].'"></span></td>';}
		else /* si status n'est pas à 0*/
			{echo '<td><span class="lnkSuppReta glyphicon glyphicon-repeat" data-stat="1" data-valeur="'.$value['id_fromage'].'"></span></td>';}

		echo "</tr>";
	}
	?>
</tbody>
</table>


<?php //AJOUT MODIFIER Formulaire ?>

<form action="" class="formAdd" method="post">
	
	<h3 id="titreForm">Modification d'un fromage</h3>
	<div id="cross" class="glyphicon glyphicon-remove"></div>
	<label id="ident" for="id_fromage">id du fromage : <span id="idFromage" ></span></label>
	<input name="id_fromage" id="id_fromage" type="hidden" min="1" max="<?php echo sizeof($res); ?>">
	<div id="dnom">
		<label for="nom">Nom :</label>
		<input name="nom" id="nom" required="required" type="text">
		
		<label for="categorie">Catégorie :</label>
		<select name="categorie" id="categorie">
			<option value="lait de vache">lait de vache</option>
			<option value="lait de chèvre">lait de chèvre</option>
			<option value="lait de brebis">lait de brebis</option>
			<option value="vins">vins</option>
			<option value="plateaux">plateaux</option>
		</select>
		<label for="prixKg">Prix /kg :</label>
		<input name="prixKg" id="prixKg" required="required" type="text">
	</div>
	
	<div id="ddescri">
		<label for="description">Description :</label>
		<textarea rows="5" cols="80" name="description" id="description" required="required"></textarea>
	</div>

	<div id="dimage">
		<label for="image">Image :</label>
		<input name="image" id="image" required="required" type="text">
	</div>

	<input id="subAjMo" type="submit" value="Ajouter/Modifier"/> 
</form>

</div>

<div id="end">
	<a href="deco.php" class="btnDeco">Déconnexion</a>
	<button id="addFromage">Ajouter un produit</button>
</div>

<?php include_once("../footer.php") ?>
<script src="../cont/js/funct.js"></script>
</body>
</html>
