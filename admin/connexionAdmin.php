<!DOCTYPE html>
<html lang="en">
<?php include_once("head.php") ?>
<body>

<?php include_once("../header.php") ?>

<?php 
require_once("connexionBDD.php");


// Deconnexion de l'utilisateur
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
	unset($_SESSION['membre']);
	session_destroy();
	header('location:connexionAdmin.php');
}


//est ce que je viens de me déconnecter?
if(isset($_GET['deco']) && $_GET['deco'] == "un"){
    echo "<p style='color: green; text-align: center;'>vous avez bien été déconnecté!</p>";
}

//reCaptcha de google
require_once('recaptchalib.php');
$siteKey = '6Lf6eCITAAAAAEBoJ_QeRmFM5nke21z782nAUufK'; // clé publique
$secret = '6Lf6eCITAAAAAOugVJGQbFFI5kSQaGp0rrGZj1qt'; // clé privée
$isOk = false;
$reCaptcha = new ReCaptcha($secret);

//Traitement connexion
if(isset($_POST["g-recaptcha-response"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"]) ){ 
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
        );
    if ($resp != null && $resp->success) 
        $isOk = true;
    else 
        $isOk = false;

    $donnees = $conn->prepare("SELECT * FROM admin");
    $donnees->execute();
    $res = $donnees->fetchAll();
    for ($i=0; $isOk && $i < sizeof($res); $i++) { 
        if($_POST['pseudo'] === $res[$i]['pseudo'] && 
           md5($_POST['mdp']) === $res[$i]['mdp']){

            $_SESSION["admin"] = true;
            $_SESSION['pseudo'] = $_POST['pseudo'];
        
            echo '<script type="text/javascript">window.location = "admin";</script>';
        }
    }
}

$reCaptcha = new ReCaptcha($secret);
if(isset($_POST["g-recaptcha-response"])) {

}


// ------- Affichage de l'HTML --------------
?>

<form id="co" method="post" action="">
    <label>Pseudo : </label><br/>
    <input type="text" name="pseudo" /><br/><br/>
    <label>Mot de passe : </label><br/>
    <input type="password" name="mdp" /><br/><br/>
    <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
    <br/><br/><button>Se connecter</button>
</form>
<?php include_once("../footer.php") ?>
</body>
</html>
