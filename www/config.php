<?php
//information sur la base de données
// A MODIFIER SI NECESSAIRE
$serveur = 'localhost';
$nomBD = 'gestionnaire_bd';
$login = 'root';
$mdp = '';

//tentative de connexion à MySQL via PDO
try
{
	$bdd = new PDO('mysql:host='.$serveur.';dbname='.$nomBD.';charset=utf8', $login, $mdp);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}



error_reporting(0); // Turn off warning, deprecated, notice everything except error
/* ------------------------------------------------------------------------------------------------
 * Fonctions utiles
 *
 *-------------------------------------------------------------------------------------------------*/
//Gère l'affichage des les variables
function debug(){
	$saut_ligne="<br />";
	$arg_list = func_get_args();
	echo '<div class="debug">'."\n";
	echo ' ------ DEBUG ------ '.$saut_ligne;
	foreach($arg_list as $var){
		if(is_array($var)){
			$affichage_var = print_r($var,true);
			$affichage_var = "<pre>".$affichage_var."</pre>".$saut_ligne;
			echo $affichage_var;
		}
		else echo $var.$saut_ligne;
	}
	echo '</div>'."\n";
}
?>