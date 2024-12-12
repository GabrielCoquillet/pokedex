		<!-- contenu de la page rechercher -->
			<h1>Recherche de BDs</h1>
			<div class="formulaire"> 
				<form action="index.php?a=rechercher" method="post">
					<fieldset>
						<legend>Critères de recherche</legend>
						<p>
							<label for="titre">Le titre contient : </label>
							<input type="text" name="titre" id="titre" value="<?php echo $_POST['titre']?>" \>
							<!--label for="auteur">Auteur : </label>
							<input type="text" name="auteur" id="auteur" value="" placeholder="Auteur"\-->
						</p>
					</fieldset>
					<p class="center"><input type="submit" value="Lister"/> <input type="reset" value="Effacer les champs"/></p>
				</form>
			</div>
<?php
debug("Contenu de POST",$_POST);
if(isset($_POST) && !empty($_POST)){
	$requete = 'SELECT * FROM bd WHERE titre LIKE "%'.$_POST['titre'].'%" ORDER BY titre ASC';
	debug("requete",$requete);
	$reponse = $bdd->query($requete);
	
	while ($donnees = $reponse->fetch()){
		//debug( $donnees);
		echo '<h1>'.$donnees['titre'].'</h1>';
		if ($donnees['image_couverture']!='') echo '<img src="images/photos_BD/'.$donnees['image_couverture'].'" width="150px"/><br/>';
		// on affiche les résultats 
		echo 'Référencé sous le n° : <strong>'.$donnees['id'].'</strong><br/>'; 
		echo 'Genre : <strong>'.$donnees['genre'].'</strong><br/>';  
		echo 'Année : <strong>'.$donnees['annee'].'</strong><br/>';  
		echo 'Numéro du tome : <strong>'.$donnees['numero_tome'].'</strong><br/>';  
		echo 'Nombre de pages : <strong>'.$donnees['nombre_pages'].'</strong><br/>';  
		if ($donnees['lien_fiche']!='') echo 'Lien fiche : <strong><a href='.$donnees['lien_fiche'].' target="_blank">'.$donnees['lien_fiche'].'</a></strong><br/>';
		echo 'Résumé : <strong>'.$donnees['resume'].'</strong><br/><br/><br/>';
		echo '<hr/>';
	};
}
?>

