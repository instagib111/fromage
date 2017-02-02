<?php  ?>
<div id="caroussel" class="row hidden-sm hidden-xs">
	<div id="slider">
		<a href="#" class="control_next">></a>
		<a href="#" class="control_prev"><</a>
		<ul id="listSlider">
			<?php

			$d = $conn->prepare("SELECT id_fromage, image, description, nom FROM produits WHERE slider = 1");
			$d->execute();
			$r = $d->fetchAll();

			foreach ($r as $key => $value) {
				echo "<li class='lnkSlider row' data-value='". $value['id_fromage'] ."' >
								<div class='col-xs-6'>
									<img src='" . $value['image'] . "' alt='". $value['nom'] ."'/>
								</div>
								<div class='col-xs-6'>
									<h3 class='col-xs-12'>".$value['nom']."</h3>
									<span class='text col-xs-12'>". $value['description'] ."</span>
								</div>
							</li>";
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
