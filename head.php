<head>
	<?php 
	$uri = $_SERVER['REQUEST_URI'];
	$prefix = '';
	$title = '';
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
	?>
	<meta charset="UTF-8">
	<title>Comté sur nous! <?= $title ?></title>
	<meta name="description" content="Vente de fromages!">
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
