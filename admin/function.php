<?php 

function userConnecte(){ //Je crée ma fonction userConnecte
	if(!isset($_SESSION['membre'])){ // $_SESSION n'est définie alors user n'est pas connecté donc retourne FAUX (0), sinon User est connecté donc retourne TRUE (1)
		return FALSE;	
	}
	else{
		return TRUE;	
	}
}

?>