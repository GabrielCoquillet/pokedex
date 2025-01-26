<!-- contenu de la page rechercher -->
<div class="recherche">
    <form action="index.php?a=rechercher" method="post">
            <p class="search">
                <select name="critere" class="search">
                    <option value="contient" class="search">Contient</option>
                    <option value="commence" class="search">Commence par</option>
                    <option value="finit" class="search">Finit par</option>
                    <option value="id" class="search">A pour id</option>
                    <option value="generation" class="search">De la génération</option>
                    <option value="categorie" class="search">De la catégorie</option>
                    <option value="type" class="search">De type</option>
                    <option value="faiblesse" class="search">A pour faiblesse le type</option>
                </select>
                <label for="reponse"></label>
                <input type="text" class ="search" name="reponse" id="reponse" value="<?php echo $_POST['titre']?>" placeholder="search pokemon">
                <button type="submit" class="search"><img src="images/search.png" width="15px" height="15px"/></button>
            </p>
    </form>
</div>
<?php
//debug("Contenu de POST",$_POST);
if(isset($_POST) && !empty($_POST)){
    if ($_POST['critere'] == 'contient') {
        $requete = 'SELECT * FROM pokemon WHERE nom LIKE "%' . $_POST['reponse'] . '%" ORDER BY nom ASC';
    }
    elseif ($_POST['critere'] == 'finit') {
        $requete = 'SELECT * FROM pokemon WHERE nom LIKE "%'. $_POST['reponse'] . '" ORDER BY nom ASC';
    }
    elseif ($_POST['critere'] == 'commence') {
        $requete = 'SELECT * FROM pokemon WHERE nom LIKE "'.$_POST['reponse'].'%" ORDER BY nom ASC';
    }
    elseif ($_POST['critere'] == 'id') {
        $requete = 'SELECT * FROM pokemon WHERE id ='.$_POST['reponse'].' ORDER BY nom ASC';
    }
    elseif ($_POST['critere'] == 'generation') {
        $requete = 'SELECT * FROM pokemon WHERE pokemon.generation ='.$_POST['reponse'].' ORDER BY pokemon.nom ASC';
    }
    elseif ($_POST['critere'] == 'type') {
        $requete = 'SELECT pokemon.id_categorie, pokemon.nom, pokemon.id, pokemon.path_to_image, pokemon.path_to_image_shiny, pokemon.taille, pokemon.poids, pokemon.attack,pokemon.pv, pokemon.defense, pokemon.vitesse FROM pokemon, type, link_type WHERE pokemon.id = link_type.id_pokemon AND link_type.id_type = type.id AND type.nom ="'.$_POST['reponse'].'" ORDER BY pokemon.nom ASC';
    }
    elseif ($_POST['critere'] == 'faiblesse') {
        $requete = 'SELECT pokemon.id_categorie, pokemon.nom, pokemon.id, pokemon.path_to_image, pokemon.path_to_image_shiny, pokemon.taille, pokemon.poids, pokemon.attack, pokemon.pv, pokemon.defense, pokemon.vitesse FROM pokemon, type, link_faiblesse WHERE pokemon.id = link_faiblesse.id_pokemon AND link_faiblesse.id_type = type.id AND type.nom ="'.$_POST['reponse'].'" ORDER BY pokemon.nom ASC';
    }
    elseif ($_POST['critere'] == 'categorie') {
        $requete = 'SELECT pokemon.id_categorie, pokemon.nom, pokemon.id, pokemon.path_to_image, pokemon.path_to_image_shiny, pokemon.taille, pokemon.poids, pokemon.attack, pokemon.pv, pokemon.defense, pokemon.vitesse FROM pokemon, categorie WHERE pokemon.id_categorie = categorie.id AND categorie.nom = "'.$_POST['reponse'].'" ORDER BY pokemon.nom ASC';
    }
    //debug("requete",$requete);
    $reponse = $bdd->query($requete);

    include 'lister.php';
}
?>

