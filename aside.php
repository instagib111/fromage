<section id="secAside" class="row">
<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null ) { // si le panier existe ?>
	<aside id="panier" class="col-xs-12 col-md-push-1 col-md-10 col-lg-push-2 col-lg-8">
		<h3 id="lblTitrePanier" >VOTRE PANIER</h3>
		<?php $cookie = unserialize($_COOKIE['panier']);
		$total = 0;
		foreach ($cookie as $key => $value) {
		?>
			<div class="dPanier col-xs-12 col-sm-6" data-id="<?php echo $value['idFromage']; ?>">
				<div class="childDPanier col-xs-12">
					<h4 class="lblTitreProduitPanier col-xs-12"><?php echo $value['nom']; ?>
						<form class="btnDelete" action="Panier/retirer" method="post">
							<input type="hidden" name="idRetirer" value="<?php echo $value['idFromage']; ?>" />
							<button id="btnRetirerPanier" class="btn btn-warning glyphicon glyphicon-remove"></button>
						</form>
					</h4>
					<div class="col-xs-6">
						<img class="imgPan" src="<?php echo $value['image']; ?>" alt="<?php echo $value['nom']; ?>" />
					</div>
					<div class="infos col-xs-6">
						<span class="col-xs-9">Quantité :</span><span class="quantitePanier tar p0 col-xs-3"><?php echo $value['quantite']; ?></span>
						<span class="col-xs-9">Poids :</span><span class="poidsPanier tar p0 col-xs-3"><?php echo $value['poids'] * 1000; ?>g</span>
						<span class="col-xs-9">Prix :</span><span class="prixPanier tar p0 col-xs-3"><?php echo $value['prix']; ?>€</span>
					</div>
				</div>
			</div>
		<?php $total += $value['prix'];} //foreach ?>
		<div class="infoPan col-xs-12">
			<form class="col-xs-12 col-sm-4" action="Panier/fermerPanier.php">
				<button id="btnEffacerPanier" class="btn btn-warning">EFFACER PANIER</button>
			</form>
			<span class="col-xs-12 col-sm-4">Prix Total: <span id="prixTotal"><?php echo $_SESSSION["prixTotal"] = number_format($total, 2) ?>€</span></span>
			<form class="col-xs-12 col-sm-4" action="Paiement/recap">
				<button class="btn btn-success">PASSER COMMANDE</button>
			</form>
		</div>
	</aside>
<?php } //endif ?>
	<!--<aside>
		<ul>
			<h3>O FROMAGES ET VINS I</h3>
			<li id="lVache" data-value="1" class="cat">Lait de vache</li>
			<li id="lChevre" data-value="2" class="cat">Lait de chèvre</li>
			<li id="lBrebis" data-value="3" class="cat">Lait de brebis</li>
			<li id="vins" data-value="4" class="cat">Vins</li>
			<li id="plateaux" data-value="5" class="cat">Plateaux</li>
		</ul>
	</aside>-->
	<form id="asideHiddenForm" action="" method="post">
		<input type="hidden" name="cat" id="asideHiddenInput" />
	</form>
</section>
