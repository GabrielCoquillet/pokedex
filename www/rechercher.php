<!-- contenu de la page rechercher -->
<h1>Recherche de BDs</h1>
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
                    <optino value="categorie">De la catégorie</optino>
                    <option value="type">De type</option>
                    <option value="faiblesse">A pour faiblesse le type</option>
                </select>
                <label for="reponse"> : </label>
                <input type="text" name="reponse" id="reponse" value="<?php echo $_POST['titre']?>"\>
            </p>
        </fieldset>
        <p class="center"><input type="submit" value="Lister"/> <input type="reset" value="Effacer les champs"/></p>
    </form>
</div>
<?php
debug("Contenu de POST",$_POST);
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
    debug("requete",$requete);
    $reponse = $bdd->query($requete);

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
}
?>

