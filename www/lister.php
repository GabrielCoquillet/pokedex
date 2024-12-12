<!-- contenu de la page -->
<?php
$reponse = $bdd->query('SELECT * FROM pokemon');

while ($donnees = $reponse->fetch()){
	//affichage de l'array $donnees
	debug( $donnees);
	
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
?>