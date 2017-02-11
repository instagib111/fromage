<?php
// si je ne trouve pas l'id dans la BDD alors je fais une rectification.
while(!isset($res[$idTemp]))
	$idTemp--;
?>
<section id="secTopArticle" class="row">
	<article id="topArticle" class="col-xs-12 col-md-push-2 col-md-8">
		<div id="inTopArticle" class="col-xs-12">
			<div class="col-xs-12 col-sm-5">
				<img id="imgTopArticle" src="<?php echo $res[$idTemp]['image']; ?>" alt="<?php  echo $res[$idTemp]['nom']; ?>" />
			</div>
			<div class="col-xs-12 col-sm-7">
				<h2 id="lblTitreDescription"><?php echo $res[$idTemp]['nom']; ?></h2>
				<p id="lblDescription"><?php echo $res[$idTemp]['description']; ?></p>
			</div>
			<form action="Panier/panier" method="post" class="formTopArticle col-xs-12 col-sm-offset-3 col-sm-6">
				<div class="col-xs-12 p0">
					<label class="tal p0 col-xs-7" id="lbQuantite" for="quantite">Quantité :</label>
					<select class="tar p0 col-xs-5" name="quantite" id="quantite">
						<?php for ($i=0; $i < 20; $i++) {
							echo '<option value="'.($i + 1).'">'.($i + 1).'</option>';
						} ?>
					</select>

					<label class="tal p0 col-xs-7" id="lbPoids" for="poids">Poids :</label>
					<select class="tar p0 col-xs-5" id="poids" name="poids">
						<option value="0.25">250g</option>
						<option value="0.5">500g</option>
						<option value="0.75">750g</option>
						<option value="1">1kg</option>
					</select>

					<h5 class="tal p0 col-xs-9">Prix TTC: </h5>
					<span class="tar p0 col-xs-3" id="prixTTC" data-prix="<?php echo $res[$idTemp]['prixKg'];?>"><?php echo number_format($res[$idTemp]['prixKg'] * 0.25, 2); ?>€</span>
					<input type="hidden" id="nomHidden" name="nom" value="<?php  echo $res[$idTemp]['nom']; ?>" />
					<input type="hidden" id="imageHidden" name="image" value="<?php echo $res[$idTemp]['image']; ?>" />
					<input type="hidden" id="prixTTCHidden" name="prixTTC" value="<?php echo number_format($res[$idTemp]['prixKg'] * 0.25, 2); ?>" />
					<input type="hidden" id="idFromageHidden" name="idFromage" value="<?php echo $res[$idTemp]['id_fromage']; ?>" />
					<input class="btn btn-success col-xs-12" id="sub" type="submit" value="Ajouter au panier"/>
				</div>
			</form>
		</div>		
	</article>
</section>
