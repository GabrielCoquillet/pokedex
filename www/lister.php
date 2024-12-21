<?php
$reponse = $bdd->query('SELECT * FROM pokemon');
while ($donnees = $reponse->fetch()){
    //debug( $donnees);
    echo '<h1>'.$donnees['nom'].'</h1>';
    $path = $donnees['path_to_image'];
    echo '<img src="'.$path.'" width="150px"><br/>';
    echo '<img src="'.$donnees['path_to_image_shiny'].'" width="150px"><br/>';
    echo 'Référencé sous le n° : <strong>'.$donnees['id'].'</strong><br/>';
    echo 'taille : <strong>'.$donnees['taille'].'</strong><br/>';
    echo 'poids : <strong>'.$donnees['poids'].'</strong><br/>';
    echo 'pv : <strong>'.$donnees['pv'].'</strong><br/>';
    echo 'atk : <strong>'.$donnees['attack'].'</strong><br/>';
    echo 'defense : <strong>'.$donnees['defense'].'</strong><br/>';
    echo 'vitesse : <strong>'.$donnees['vitesse'].'</strong><br/>';
    echo '<hr/>';
};

?>
