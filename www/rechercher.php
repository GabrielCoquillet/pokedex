<link rel="stylesheet" href="style_rechercher.css">
<h1>Recherche de pokemon</h1>
<div class="formulaire">
    <form action="index.php?a=rechercher" method="post">
        <fieldset>
            <legend>Critères de recherche</legend>
            <p>
                <select name="critere" id="critere" >
                    <option value="contient">Contient</option>
                    <option value="commence">Commence par</option>
                    <option value="finit">Finit par</option>
                    <option value="id">A pour id</option>
                    <option value="generation">De la génération</option>
                    <option value="categorie">De la catégorie</option>
                    <option value="type">De type</option>
                    <option value="faiblesse">A pour faiblesse le type</option>
                </select>
                <label for="reponse"></label>
                <input type="text" name="reponse" id="reponse" value="<?php echo $_POST['titre']?>"\>
            </p>
        </fieldset>
        <p class="center"><input type="submit" value="Lister"/> <input type="reset" value="Effacer les champs"/></p>
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
        $requete = 'SELECT * FROM pokemon, link_generation, generation WHERE link_generation.id_pokemon = pokemon.id AND link_generation.id_generation ='.$_POST['reponse'].' ORDER BY pokemon.nom ASC';
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
