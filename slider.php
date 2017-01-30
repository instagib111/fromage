<?php  ?>
<div id="caroussel">
	<div id="slider">
		<a href="#" class="control_next">></a>
		<a href="#" class="control_prev"><</a>
		<ul>
			<?php

			$d = $conn->prepare("SELECT id_fromage, image, description, nom FROM produits WHERE slider = 1");
			$d->execute();
			$r = $d->fetchAll();

			foreach ($r as $key => $value) {
				echo "<li class='lnkSlider' data-value='". $value['id_fromage'] ."' >
				<img src='" . $value['image'] . "' alt='". $value['nom'] ."'/><div><h3>".$value['nom']."</h3><span class='text'>". $value['description'] ."</span><span></span></div></li>";
			}

			?>
		</ul>
	</div>
	<form id="hiddenForm" action="" method="post">
		<input id="hiddenAttr" name="id" type="hidden">
	</form>

	<link href="cont/stylesheets/slider.css" rel="stylesheet" />
	<script src="cont/js/slider.js"></script>
</div>