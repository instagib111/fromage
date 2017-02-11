<?php require_once("connexionBDD.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php include_once("../head.php") ?>
<body>

<?php include_once("../header.php");

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
$siteKey = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; // clé publique FAKE
$secret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe'; // clé privée FAKE
//$siteKey = '6Lf6eCITAAAAAEBoJ_QeRmFM5nke21z782nAUufK'; // clé publique
//$secret = '6Lf6eCITAAAAAOugVJGQbFFI5kSQaGp0rrGZj1qt'; // clé privée
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
        
            header('Location: admin');
            die();
        }
    }
}

// ------- Affichage de l'HTML --------------
?>
<div class="divco row">
    <form id="co" class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4" method="post" action="">
        <label class="col-xs-12 lbl" >Identifiant : </label>
        <input class="col-xs-12"  type="text" name="pseudo" />
        <label class="col-xs-12 lbl" >Mot de passe : </label>
        <input class="col-xs-12"  type="password" name="mdp" />
        <div class="col-xs-12 recap">
            <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        </div>
        <button class="col-xs-12 btn btn-success" >Se connecter</button>
    </form>
</div>
<?php include_once("../footer.php") ?>
</body>
</html>
