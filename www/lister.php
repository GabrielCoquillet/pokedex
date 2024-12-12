<?php
$reponse = $bdd->query('SELECT * FROM pokemon');
while ($donnees = $reponse->fetch()){
    //debug( $donnees);
    echo '<h1>'.$donnees['nom'].'</h1>';
    $path = $donnees['path_to_image'];
    echo '<img src="'.$path.'" width="150px"><br/>';
    echo 'Référencé sous le n° : <strong>'.$donnees['id'].'</strong><br/>';
    echo 'dsescription : <strong>'.$donnees['description'].'</strong><br/>';
    echo 'sexe : <strong>'.$donnees['sexe'].'</strong><br/>';
    echo 'taille : <strong>'.$donnees['taille'].'</strong><br/>';
    echo 'poids : <strong>'.$donnees['poiuds'].'</strong><br/>';
    echo 'pv : <strong>'.$donnees['pv'].'</strong><br/><br/><br/>';
    echo '<hr/>';
};

?>
