<!-- contenu de la page rechercher -->
<h1>Ajouter un pokemon</h1>
<div class="formulaire">
    <form action="index.php?a=ajouter" method="post" enctype="multipart/form-data">
            <h2>Informations du pokémon à ajouter</h2>
            <p>
                <label for="nom"></label>
                <input type="text" name="nom" id="nom" value="" placeholder="Nom"\>

                <label for="categorie"></label>
                <input type="text" name="categorie" id="categorie" value="" placeholder="Catégorie"\>

                <label for="generation"></label>
                <input type="text" name="generation" id="generation" value="" placeholder="generation"\>

                <label for="taille"></label>
                <input type="text" name="taille" id="taille" value="" placeholder="taille"\>

                <label for="poids"></label>
                <input type="text" name="poids" id="poids" value="" placeholder="poids"\>

                <label for="pv"></label>
                <input type="text" name="pv" id="pv" value="" placeholder="pv"\>

                <label for="attack"></label>
                <input type="text" name="attack" id="attack" value="" placeholder="attack"\>

                <label for="def"></label>
                <input type="text" name="def" id="def" value="" placeholder="def"\>

                <label for="vit"></label>
                <input type="text" name="vit" id="vit" value="" placeholder="vit"\>

                <div class="dropdown">
                    <button type="button">Selectionnez les types du pokemon</button>
                    <div class="dropdown-content">
                        <?php
                            $types = $bdd->query("SELECT nom FROM type");
                            while ($type = $types->fetch()) {
                                echo '<label><input type="checkbox" name="types[]" value="'.$type['nom'].'">'.$type['nom'].'</label>';
                            }
                        ?>
                    </div>
                </div>
                <div class="dropdown">
                    <button type="button">Selectionnez les faiblesses du pokemon</button>
                    <div class="dropdown-content">
                        <?php
                        $types = $bdd->query("SELECT nom FROM type");
                        while ($type = $types->fetch()) {
                            echo '<label><input type="checkbox" name="faiblesses[]" value="'.$type['nom'].'">'.$type['nom'].'</label>';
                        }
                        ?>
                    </div>
                </div>
            </p>
            <p>
                <button type="button" onclick="document.getElementById('image_poke').click()">regular</button>
                <button type="button" onclick="document.getElementById('image_poke_shiny').click()">shiny</button>

                <input type="file" name="image_poke" id="image_poke" style="display: none"/>


                <input type="file" name="image_poke_shiny" id="image_poke_shiny" style="display: none"/>
            </p>
        <p class="center"><button type="submit">Ajouter</button> <button type="reset">Effacer les champs</button></p>
    </form>
</div>

<?php
// Testons si le fichier a bien été envoyé et s'il n'y a pas des erreurs
if (isset($_FILES['image_poke']) && $_FILES['image_poke']['error'] === 0 && isset($_FILES['image_poke_shiny']) && $_FILES['image_poke_shiny']['error'] === 0) {
    // Testons, si le fichier est trop volumineux
    if ($_FILES['image_poke']['size'] > 5000000000000000000 or $_FILES['image_poke_shiny']['size'] > 5000000000000000000) {
        echo "L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse";
        return;
    }
    // Testons, si l'extension n'est pas autorisée
    $fileInfo = pathinfo($_FILES['image_poke']['name']);
    $fileInfoShiny = pathinfo($_FILES['image_poke_shiny']['name']);
    $extension = $fileInfo['extension'];
    $extensionShiny = $fileInfoShiny['extension'];
    $allowedExtensions = ['jpg', 'png'];
    if (!in_array($extension, $allowedExtensions) or !in_array($extensionShiny, $allowedExtensions)){
        echo "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée";
        return;
    }
    // Testons, si le dossier uploads est manquant
    $path = __DIR__ . '/images/';
    if (!is_dir($path)) {
        echo "L'envoi n'a pas pu être effectué, le dossier images est manquant";
        return;
    }
    $path_bdd = 'images/'. basename($_FILES['image_poke']['name']);
    $path_bdd_shiny = 'images/'. basename($_FILES['image_poke_shiny']['name']);
    $new_path = $path . basename($_FILES['image_poke']['name']);
    $new_path_shiny = $path . basename($_FILES['image_poke_shiny']['name']);

    // On peut valider le fichier et le stocker définitivement
    move_uploaded_file($_FILES['image_poke']['tmp_name'], $new_path);
    move_uploaded_file($_FILES['image_poke_shiny']['tmp_name'], $new_path_shiny);


}elseif(isset($_FILES['image_poke']) && $_FILES['image_poke']['error'] !== 0 or isset($_FILES['image_poke_shiny']) && $_FILES['image_poke_shiny']['error'] !== 0) {
    echo 'Une erreur est survenue lors de l\'upload';
}
if (isset($_POST['nom']) && isset($_POST['categorie']) && isset($_POST['generation']) && isset($_POST['taille']) && isset($_POST['poids']) && isset($_POST['pv']) && isset($_POST['attack']) && isset($_POST['def']) && isset($_POST['vit']) && isset($_POST['types']) && isset($_POST['faiblesses'])) {
    $categorie = $bdd->prepare("SELECT id FROM categorie WHERE nom=:nom");
    $categorie->BindValue(':nom', $_POST['categorie']);
    $categorie->execute();
    if ($categorie->rowCount() == 0) {
        $requete = $bdd->prepare("INSERT INTO categorie (nom) VALUES (:nom)");
        $requete->bindValue(':nom', $_POST['categorie']);
        $requete->execute();

        $categorie = $bdd->prepare("SELECT id FROM categorie WHERE nom=:nom");
        $categorie->BindValue(':nom', $_POST['categorie']);
        $categorie->execute();
    }
    $categorie = $categorie->fetch()[0];

    $requete = $bdd->prepare('INSERT INTO pokemon (nom, id_categorie, path_to_image, path_to_image_shiny, taille, poids, pv, attack, vitesse, defense, generation) VALUES (:nom, :categorie, :path, :path_shiny,  :taille, :poids, :pv, :attack, :vitesse, :defense, :generation)');
    $requete->bindValue(':nom', $_POST['nom']);
    $requete->bindValue(':categorie', $categorie);
    $requete->bindValue(':path', $path_bdd);
    $requete->bindValue(':path_shiny', $path_bdd_shiny);
    $requete->bindValue(':taille', $_POST['taille']);
    $requete->bindValue(':poids', $_POST['poids']);
    $requete->bindValue(':pv', $_POST['pv']);
    $requete->bindValue(':attack', $_POST['attack']);
    $requete->bindValue(':vitesse', $_POST['vit']);
    $requete->bindValue(':defense', $_POST['def']);
    $requete->bindValue(':generation', intval($_POST['generation']));
    $requete->execute();

    $id_new_poke = $bdd->lastInsertId();

    foreach ($_POST['types'] as $type) {
        $id_type = $bdd->prepare("SELECT id FROM type WHERE nom=:nom");
        $id_type->bindValue(':nom', $type);
        $id_type->execute();
        $id_type = $id_type->fetch()[0];

        $requete = $bdd->prepare("INSERT INTO link_type(id_type, id_pokemon) VALUES (:id_type, :id_pokemon)");
        $requete->bindValue(':id_type', $id_type);
        $requete->bindValue(':id_pokemon', $id_new_poke);
        $requete->execute();
    }

    foreach ($_POST['faiblesses'] as $type) {
        $id_type = $bdd->prepare("SELECT id FROM type WHERE nom=:nom");
        $id_type->bindValue(':nom', $type);
        $id_type->execute();
        $id_type = $id_type->fetch()[0];

        $requete = $bdd->prepare("INSERT INTO link_faiblesse(id_type, id_pokemon) VALUES (:id_type, :id_pokemon)");
        $requete->bindValue(':id_type', $id_type);
        $requete->bindValue(':id_pokemon', $id_new_poke);
        $requete->execute();

    }
    $requete = 'SELECT * FROM pokemon WHERE id ='.$id_new_poke.' ORDER BY nom ASC';
    $reponse = $bdd->query($requete);
    include 'lister.php';

}


