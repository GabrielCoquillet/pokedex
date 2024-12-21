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
    $requete = 'SELECT * FROM pokemon WHERE nom LIKE "%'.$_POST['titre'].'%" ORDER BY nom ASC';
    //debug("requete",$requete);
    $reponse = $bdd->query($requete);

    while ($donnees = $reponse->fetch()){
        //debug( $donnees);
        echo '<h1>'.$donnees['nom'].'</h1>';
        $path = $donnees['path_to_image'];
        echo '<img src="'.$path.'" width="150px"><br/>';
        echo 'Référencé sous le n° : <strong>'.$donnees['id'].'</strong><br/>';
        echo 'taille : <strong>'.$donnees['taille'].'</strong><br/>';
        echo 'poids : <strong>'.$donnees['poids'].'</strong><br/>';
        echo 'pv : <strong>'.$donnees['pv'].'</strong><br/><br/><br/>';
        echo '<hr/>';
    };
}
?>

