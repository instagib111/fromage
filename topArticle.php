<?php
// si je ne trouve pas l'id dans la BDD alors je fais une rectification.
while(!isset($res[$idTemp]))
	$idTemp--;
?>
<article id="topArticle">
	<img src="<?php echo $res[$idTemp]['image']; ?>" alt="<?php  echo $res[$idTemp]['nom']; ?>" />
	<div>
		<h2><?php echo $res[$idTemp]['nom']; ?></h2>
		<p><?php echo $res[$idTemp]['description']; ?></p>
	</div>
	<form action="Panier/panier" method="post">
		<fieldset>
		<label id="lbQuantite" for="quantite">Quantité :</label>
		<select name="quantite" id="quantite">
			<?php for ($i=0; $i < 20; $i++) { 
				echo '<option value="'.($i + 1).'">'.($i + 1).'</option>';
			} ?>
		</select><br />

		<label id="lbPoids" for="poids">Poids :</label>
		<select id="poids" name="poids">
			<option value="0.25">250g</option>
			<option value="0.5">500g</option>
			<option value="0.75">750g</option>
			<option value="1">1kg</option>
		</select><br />

		<h5>Prix TTC: <span id="prixTTC" data-prix="<?php echo $res[$idTemp]['prixKg'];?>"><?php echo number_format($res[$idTemp]['prixKg'] * 0.25, 2); ?>€</span></h5>
		<input type="hidden" id="nomHidden" name="nom" value="<?php  echo $res[$idTemp]['nom']; ?>" />
		<input type="hidden" id="imageHidden" name="image" value="<?php echo $res[$idTemp]['image']; ?>" />
		<input type="hidden" id="prixTTCHidden" name="prixTTC" value="<?php echo number_format($res[$idTemp]['prixKg'] * 0.25, 2); ?>" />
		<input type="hidden" id="idFromageHidden" name="idFromage" value="<?php echo $res[$idTemp]['id_fromage']; ?>" />
		<input id="sub" type="submit" value="Ajouter au panier"/> 
		</fieldset>
	</form>
</article>