<?php
	require("../admin/connexionBDD.php");
	if (isset($_COOKIE['panier']) && $_COOKIE['panier'] != null) { // si le cookie existe

		$emailV = "achard.christopher@gmail.com";
		$emailA = $_SESSION['email'];
		$sujetV = "Votre dernière vente!";
		$sujetA = "Votre dernière achat!";


		//mail pour vendeur et acheteur
		$headerV = "From: automail@comtesurnous.fr" . "\r\n";
		$headerV .= "Reply-To:$emailV\r\n";
		$headerV .= "MIME-Version: 1.0 \r\n";
		$headerV .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$headerV .= "X-Mailer:PHP/" . phpversion();

		$headerA = "From: automail@comtesurnous.fr" . "\r\n";
		$headerA .= "Reply-To:$emailA\r\n";
		$headerA .= "MIME-Version: 1.0 \r\n";
		$headerA .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$headerA .= "X-Mailer:PHP/" . phpversion();

		$bodyVH = "<h1>Votre dernière vente !</h1>";
		$bodyAH = "<h1>Votre dernière achat sur comtesurnous.fr !</h1>";
		$cookie = unserialize($_COOKIE['panier']);
		$body = "<h3>Panier commandé</h3>";
		foreach ($cookie as $key => $value) {
			$body .= "<h4>".$value['nom']."</h4>";
			//$body .= "id du fromage : ".$value['idFromage']."<br />";
			$body .= "Quantite : ".$value['quantite']."<br />";
			$body .= "Poids/u: ".$value['poids']." g<br />";
			$body .= "Prix : ".$value['prix']." €<br />";
		} //end foreach
		$body .= "<br /><br />Poids Total: ".$_SESSION['poidsTotal']."g<br />";
		$body .= "Prix livraison: ".$_SESSION["prixLivraison"]."€<br />";
		$body .= "Prix Total: ".number_format($_SESSION['prixTotal'], 2)."€<br /><br />";


		$body .= "Nom : ".$_SESSION['nom']."<br />";
		$body .= "Prénom : ".$_SESSION['prenom']."<br />";
		$body .= "Email : ".$_SESSION['email']."<br /><br />";

		$body .= "<h2>Adresse de facturation.</h2><br />";
		$body .= "Adresse : ".$_SESSION['adresseF']."<br />";
		$body .= "Code Postal : ".$_SESSION['codePostalF']."<br />";
		$body .= "Ville : ".$_SESSION['villeF']."<br />";
		$body .= "Pays : ".$_SESSION['paysF']."<br /><br />";

		$body .= "<h2>Adresse de livraison.</h2><br />";
		$body .= "Adresse : ".$_SESSION['adresseL']."<br />";
		$body .= "Code Postal : ".$_SESSION['codePostalL']."<br />";
		$body .= "Ville : ".$_SESSION['villeL']."<br />";
		$body .= "Pays : ".$_SESSION['paysL']."<br /><br />";

		$bodyAF = "Email du vendeur: " . $emailV;

		
		mail($emailV, $sujetV, $bodyVH . $body, $headerV); //4 arguments dans l'ordre : 1/destinataire 2/ sujet (objet) 3/message 4/ header

		mail($emailA, $sujetA, $bodyAH . $body . $bodyAF, $headerA);

		/*commandes

		`id_commande` int(11) NOT NULL AUTO_INCREMENT,
		`panier` text NOT NULL,
		`nom` varchar(255) NOT NULL,
		`prenom` varchar(255) NOT NULL,
		`adresse` text NOT NULL,
		`prix` varchar(50) NOT NULL,
		`date_commande` datetime NOT NULL,
		`date_envoye` date NOT NULL,
		`date_delivre` date NOT NULL,
		`statut` int(11) NOT NULL,
		PRIMARY KEY (`id_commande`)*/

		
		$adresseF = isset($_SESSION['adresseF']) ? $_SESSION['adresseF'] : "";
		$adresseL = isset($_SESSION['adresseL']) ? $_SESSION['adresseL'] : "";

		$cpF = isset($_SESSION['codePostalF']) ? $_SESSION['codePostalF'] : "";
		$cpL = isset($_SESSION['codePostalL']) ? $_SESSION['codePostalL'] : "";

		$villeF = isset($_SESSION['villeF']) ? $_SESSION['villeF'] : "";
		$villeL = isset($_SESSION['villeL']) ? $_SESSION['villeL'] : "";

		$arrAdresse = array(
				"adresseF" => $adresseF,
				"adresseL" => $adresseL,
				"cpF" => $cpF,
				"cpL" => $cpL,
				"villeF" => $villeF,
				"villeL" => $villeL
			);
		$serAdresse = serialize($arrAdresse);

		$prix = $_SESSION['prixTotal'];

		$sql = "INSERT INTO commandes(panier, nom, prenom, adresse, prix, date_commande)
				VALUES (:panier, :nom, :prenom, :adresse, :prix, NOW())";
		$up = $conn->prepare($sql);
		$up->bindParam(':panier', $_COOKIE["panier"], PDO::PARAM_STR);
		$up->bindParam(':nom', $_SESSION['nom'], PDO::PARAM_STR);
		$up->bindParam(':prenom', $_SESSION['prenom'], PDO::PARAM_STR);
		$up->bindParam(':adresse',$serAdresse, PDO::PARAM_STR);
		$up->bindParam(':prix', $prix , PDO::PARAM_STR);
		$up->execute();

		header('Location: ../Panier/fermerPanier');
		die();

	} // end if 

	header('Location: ../index');
	die();
	
?>