<head>
	<?php 
	$uri = $_SERVER['REQUEST_URI'];
	$prefix = '';
	$title = 'Lait de chèvre.';
	$isInAdminFolder = strstr($uri, '/admin/');
	$isInPaiementFolder = strstr($uri, '/Paiement/');

	if ($isInAdminFolder){
		$prefix = '../';
		$title = ' - Administration';
	}
	if ($isInPaiementFolder){
		$prefix = '../';
		$title = ' - Paiement';
	}
	if(!isset($_POST['cat'])){ $title = $cat = "lait de vache";}
	else if($_POST['cat'] == 1) { $title = $cat = "lait de vache";}
	else if($_POST['cat'] == 2) { $title = $cat = "lait de chèvre";}
	else if($_POST['cat'] == 3) { $title = $cat = "lait de brebis";}
	else if($_POST['cat'] == 4) { $title = $cat = "vins";}
	else if($_POST['cat'] == 5) { $title = $cat = "plateaux";}
	?>
	<meta charset="UTF-8">
	<title>Comté sur nous - <?= ucfirst($title) ?></title>
	<meta name="description" content="Venez découvrir une gamme de produit traditionnel Français. 
	Fromage, vins, plateaux composé... Lait de chèvre, brebis ou vache sur comtesurnous.fr">
	<!-- récupère les dimmenssions css des périfériques -->
	<meta name="viewport" content="width=device-width" />
	<!-->
	<link href="cont/stylesheets/bootstrap.min.css" rel="stylesheet" />
	<script src="cont/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
	</!-->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="<?= $prefix ?>cont/stylesheets/style.css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
