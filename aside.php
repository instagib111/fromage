<section id="secAside">
<?php if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null ) { // si le panier existe ?>
	<aside id="panier">
		<h3>VOTRE PANIER</h3>
		<?php $cookie = unserialize($_COOKIE['panier']);
		$total = 0;
		foreach ($cookie as $key => $value) {
		?>
			<div class="dPanier" data-id="<?php echo $value['idFromage']; ?>">

				<h4><?php echo $value['nom']; ?></h4>
				<form action="Panier/retirer" method="post">
					<input type="hidden" name="idRetirer" value="<?php echo $value['idFromage']; ?>" />
					<button id="btnRetirerPanier" class="glyphicon glyphicon-remove"></button>
				</form>
				<img class="imgPan" src="<?php echo $value['image']; ?>" alt="<?php echo $value['nom']; ?>" />
				<div>	

					<span>Quantité :<span class="quantitePanier"><?php echo $value['quantite']; ?></span></span><br />
					<span>Poids :<span class="poidsPanier"><?php echo $value['poids'] * 1000; ?>g</span></span><br />
					<span>Prix :<span class="prixPanier"><?php echo $value['prix']; ?>€</span></span>
				</div>
			</div>
		<?php $total += $value['prix'];} //foreach ?>
		<form action="Panier/fermerPanier.php">
			<button id="btnEffacerPanier">EFFACER PANIER</button>
		</form>
		<div class="prixTotal">
			<span>Prix Total: <span id="prixTotal"><?php echo $_SESSSION["prixTotal"] = number_format($total, 2) ?>€</span></span>
			<form action="Paiement/recap">
				<button>PASSER COMMANDE</button>
			</form>
		</div>
	</aside>
<?php } //endif ?>
	<aside>
		<ul>
			<h3>O FROMAGES ET VINS I</h3>
			<li id="lVache" data-value="1" class="cat">Lait de vache</li>
			<li id="lChevre" data-value="2" class="cat">Lait de chèvre</li>
			<li id="lBrebis" data-value="3" class="cat">Lait de brebis</li>
			<li id="vins" data-value="4" class="cat">Vins</li>
			<li id="plateaux" data-value="5" class="cat">Plateaux</li>
		</ul>
	</aside>
	<form id="asideHiddenForm" action="" method="post">
		<input type="hidden" name="cat" id="asideHiddenInput" />
	</form>
</section>