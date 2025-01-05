<?php
$reponse = $bdd->query('SELECT * FROM pokemon');

while ($donnees = $reponse->fetch()){
    //debug( $donnees);

    //on récupère la catégorie associée au pokémon
    $categorie = $bdd->prepare('SELECT nom FROM categorie WHERE id=:nom_categorie');
    $categorie->bindValue(':nom_categorie', $donnees['id_categorie']);
    $categorie->execute();
    $nom_categorie = $categorie->fetch();

    //affichage du nom du pokémon
    echo '<h1>'.$donnees['nom'].'</h1>';

    //affichage des sprites du pokémon (regular et shiny)
    echo '<img src="'.$donnees['path_to_image'].'" width="150px"><br/>';
    echo '<img src="'.$donnees['path_to_image_shiny'].'" width="150px"><br/>';

    //affichage des infos concernant le pokémon
    echo 'Référencé sous le n° : <strong>'.$donnees['id'].'</strong><br/>';
    echo 'Catégorie : <strong>'.$nom_categorie[0].'</strong><br/>';
    echo 'taille : <strong>'.$donnees['taille'].'</strong><br/>';
    echo 'poids : <strong>'.$donnees['poids'].'</strong><br/>';
    echo 'pv : <strong>'.$donnees['pv'].'</strong><br/>';
    echo 'atk : <strong>'.$donnees['attack'].'</strong><br/>';
    echo 'defense : <strong>'.$donnees['defense'].'</strong><br/>';
    echo 'vitesse : <strong>'.$donnees['vitesse'].'</strong><br/>';

    //on récupère le/les id du/des type/types associés au pokémon
    $types = $bdd->prepare('SELECT id_type FROM link_type WHERE id_pokemon=:id_pokemon');
    $types->bindValue(':id_pokemon', $donnees['id']);
    $types->execute();

    //affichage du/des type/types du pokémon
    echo 'Type(s) : <strong>';
    while ($type = $types->fetch()){
        //on récupère le nom de chaque type associé au pokémon
        $nom_type = $bdd->prepare('SELECT nom FROM type WHERE id=:id_type');
        $nom_type->bindValue(':id_type', $type['id_type']);
        $nom_type->execute();
        $type_nom = $nom_type->fetch();
        //on affiche le nom de chaque type associé au pokémon
        echo $type_nom['nom'].' ';
    }
    echo '</strong><br/>';

    //affiche du/des faiblesse/faiblesses du pokémon
    $faiblesses = $bdd->prepare('SELECT id_type FROM link_faiblesse WHERE id_pokemon=:id_pokemon');
    $faiblesses->bindValue(':id_pokemon', $donnees['id']);
    $faiblesses->execute();
    echo 'Faiblesse(s) : <strong>';
    while ($faiblesse = $faiblesses->fetch()){
        $nom_faiblesse = $bdd->prepare('SELECT nom FROM type WHERE id=:id_type');
        $nom_faiblesse->bindValue(':id_type', $faiblesse['id_type']);
        $nom_faiblesse->execute();
        $faiblesse_nom = $nom_faiblesse->fetch();
        echo $faiblesse_nom['nom'].' ';
    }
    echo '</strong><br/>';

    //affichage des variantes régionales du pokémon
    $variante = $bdd->prepare('SELECT id_region FROM link_region WHERE id_pokemon=:id_pokemon');
    $variante->bindValue(':id_pokemon', $donnees['id']);
    $variante->execute();
    echo 'Variante(s) régionale(s) : <strong>';
    if ($variante->rowCount() == 0){
        echo 'Aucune </strong><br/>';
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

    //affichage de la génération d'apparition du pokémon
    $gen = $bdd->prepare('SELECT id_generation FROM link_generation WHERE id_pokemon=:id_pokemon');
    $gen->bindValue(':id_pokemon', $donnees['id']);
    $gen->execute();
    echo "Génération d'apparition du pokémon :<strong> génération ".$gen->fetch()[0]."</strong><br/>";
    echo '<hr/>';
};

?>
