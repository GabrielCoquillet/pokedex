<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Gestionnaire de BDs</title>
		<link rel="icon" type="image/png" href="images/book.png" />
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		<?php include("config.php"); ?>
		<!-- titre -->
		<div id="div_titre">
			<h1>Gestionnaire de BDs</h1>  
		</div>
		<div class="clear"></div>

		<!-- menu -->
		<div id="menu">
			<ul id="onglets">
				<li><a href="index.php?a=lister">Liste des BDs</a></li>
				<li><a href="index.php?a=rechercher">Recherche</a></li>
				<li><a href="index.php?a=ajouter">Ajout</a></li>
			</ul>
		</div>

		<!-- contenu de la page -->
		<div id="contenu">
		<?php 
		//orientation vers la bonne page
		if (isset($_GET['a']) && !empty($_GET['a'])) {
			// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
			$action = (!empty($_GET['a'])) ? $_GET['a'].'.php' : 'index.php';
			
			// Si l'action existe, on l'exécute
			if (is_file($action)) {
				include $action;
			// Sinon, on affiche la page d'index du module !
			} 
		// Module non specifié ou invalide ? On affiche la page d'accueil !
		} 
		else {
			include 'lister.php';
		}
		?>
		</div>
		</div>
		
		<!-- Pied de page -->
		<div id="footer">
			Nom éléve 1<br/>
			Nom éléve 2<br/>
			Nom éléve 3<br/>
			Novembre 2020
		</div>
	</body>
</html>
	