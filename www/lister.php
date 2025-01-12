<?php
if (isset($_POST['delete'])) {
    $requete = $bdd->prepare('DELETE FROM pokemon WHERE id=:id');
    $requete->bindValue(':id', $_POST['delete']);
    //$requete->execute();
    $reponse = $bdd->query("SELECT * FROM pokemon");
}

echo '<table>';
echo "<tr class='header'>
         <th class='header'>Sprites</th>
         <th class='header'>Id</th>
         <th class='header'>Nom</th>
         <th class='header'>catégorie</th>
         <th class='header'>taille</th>
         <th class='header'>poids</th>
         <th class='header'>pv</th>
         <th class='header'>attaque</th>
         <th class='header'>défense</th>
         <th class='header'>vitesse</th>
         <th class='header'>type(s)</th>
         <th class='header'>faiblesse(s)</th>
         <th class='header'>variante régionale</th>
         <th class='header'>génération</th>
         <th class='header'>est l'évolution de</th>
         <th class='header'>évolution</th>
         <th class='header'>Suppression</th>
  	   </tr>";
while ($donnees = $reponse->fetch()){
    //debug( $donnees);
    echo '<tr>';

    //affichage des sprites du pokémon (regular et shiny)
    echo '<th>';
    echo '<img src="'.$donnees['path_to_image'].'" width="150px">';
    echo '<img src="'.$donnees['path_to_image_shiny'].'" width="150px">';
    echo '</th>';

    //affichage de l'id
    echo '<th><strong>'.$donnees['id'].'</strong></th>';

    //affichage nom
    echo '<th>'.$donnees['nom'].'</th>';


    //on récupère la catégorie associée au pokémon
    $categorie = $bdd->prepare('SELECT nom FROM categorie WHERE id=:nom_categorie');
    $categorie->bindValue(':nom_categorie', $donnees['id_categorie']);
    $categorie->execute();
    $nom_categorie = $categorie->fetch();
    //affichage catégorie
    echo '<th><strong>'.$nom_categorie[0].'</strong></th>';

    //affichage taille
    echo '<th><strong>'.$donnees['taille'].'</strong></th>';
    //affichage poids
    echo '<th><strong>'.$donnees['poids'].'</strong></th>';
    //affichage pv
    echo '<th><strong>'.$donnees['pv'].'</strong></th>';
    //affichage attaque
    echo '<th><strong>'.$donnees['attack'].'</strong></th>';
    //affichage defense
    echo '<th><strong>'.$donnees['defense'].'</strong></th>';
    //affichage vitesse
    echo '<th><strong>'.$donnees['vitesse'].'</strong></th>';

    //on récupère le/les id du/des type/types associés au pokémon
    $types = $bdd->prepare('SELECT id_type FROM link_type WHERE id_pokemon=:id_pokemon');
    $types->bindValue(':id_pokemon', $donnees['id']);
    $types->execute();

    //affichage du/des type/types du pokémon
    echo '<th><strong>';
    while ($type = $types->fetch()){
        //on récupère le nom de chaque type associé au pokémon
        $nom_type = $bdd->prepare('SELECT nom FROM type WHERE id=:id_type');
        $nom_type->bindValue(':id_type', $type['id_type']);
        $nom_type->execute();
        $type_nom = $nom_type->fetch();
        //on affiche le nom de chaque type associé au pokémon
        echo $type_nom['nom'].'<br/>';
    }
    echo '</th>';

    //affiche du/des faiblesse/faiblesses du pokémon
    $faiblesses = $bdd->prepare('SELECT id_type FROM link_faiblesse WHERE id_pokemon=:id_pokemon');
    $faiblesses->bindValue(':id_pokemon', $donnees['id']);
    $faiblesses->execute();
    echo '<th><strong>';
    while ($faiblesse = $faiblesses->fetch()){
        $nom_faiblesse = $bdd->prepare('SELECT nom FROM type WHERE id=:id_type');
        $nom_faiblesse->bindValue(':id_type', $faiblesse['id_type']);
        $nom_faiblesse->execute();
        $faiblesse_nom = $nom_faiblesse->fetch();
        echo $faiblesse_nom['nom'].'<br/>';
    }
    echo '</th>';

    //affichage des variantes régionales du pokémon
    $variante = $bdd->prepare('SELECT id_region FROM link_region WHERE id_pokemon=:id_pokemon');
    $variante->bindValue(':id_pokemon', $donnees['id']);
    $variante->execute();
    echo '<th>';
    if ($variante->rowCount() == 0){
        echo 'Aucune';
    }
    else {
        while ($region = $variante->fetch()) {
            $nom_region = $bdd->prepare('SELECT nom FROM region WHERE id=:id_region');
            $nom_region->bindValue(':id_region', $region['id_region']);
            $nom_region->execute();
            $region_nom = $nom_region->fetch();
            echo $region_nom['nom'] . ' ';
        }
    }
    echo '</th>';

    //affichage de la génération d'apparition du pokémon
    $gen = $bdd->prepare('SELECT id_generation FROM link_generation WHERE id_pokemon=:id_pokemon');
    $gen->bindValue(':id_pokemon', $donnees['id']);
    $gen->execute();
    echo "<th><strong> génération ".$gen->fetch()[0]."</strong></th>";

    //affichage des évolutions...
    $familles = $bdd->prepare('SELECT * FROM famille WHERE id_pokemon_base=:id OR id_pokemon_level_2=:id OR id_pokemon_level_3=:id');
    $familles->bindValue(':id', $donnees['id']);
    $familles->execute();
    if ($familles->rowCount() == 0){
        echo '<th>Aucun</th>';
        echo '<th>Aucun</th>';
    }
    while ($famille = $familles->fetch()) {
        $nom_2 = $bdd->prepare('SELECT nom FROM pokemon WHERE id=:id');
        $nom_2->bindValue(':id', $famille['id_pokemon_level_2']);
        $nom_2->execute();
        $nom_2 = $nom_2->fetch()[0];

        $nom_3 = $bdd->prepare('SELECT nom FROM pokemon WHERE id=:id');
        $nom_3->bindValue(':id', $famille['id_pokemon_level_3']);
        $nom_3->execute();
        $nom_3 = $nom_3->fetch()[0];

        $nom_base = $bdd->prepare('SELECT nom FROM pokemon WHERE id=:id');
        $nom_base->bindValue(':id', $famille['id_pokemon_base']);
        $nom_base->execute();
        $nom_base = $nom_base->fetch()[0];

        if ($famille['id_pokemon_base'] == $donnees['id']) {
            echo "<th>Aucun</th>";
            echo "<th><strong> " . $nom_2 . " " . $nom_3 . "</strong></th>";
        }
        elseif ($famille['id_pokemon_level_2'] == $donnees['id']) {

            echo "<th><strong>". $nom_base ."</strong></th>";
            echo "<th><strong>". $nom_3 ."</strong></th>";
        }
        elseif ($famille['id_pokemon_level_3'] == $donnees['id']) {
            echo '<th>Aucun</th>';
            echo "<th><strong>". $nom_base ." ". $nom_2 ."</strong></th>";
        }
    }


    echo "<th><form action='index.php?a=lister' method='POST'><label><input type='checkbox' name='delete' id='delete' value='".$donnees['id']."'></label>Supprimer le pokemon ?<button type='submit'>Valider la suppression</button></form></th>";
    echo '</tr>';
};

echo '</table>';
?>
