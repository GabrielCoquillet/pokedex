<!-- contenu de la page rechercher -->
<h1>Ajouter un pokemon</h1>
<div class="formulaire">
    <form action="index.php?a=ajouter" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Informations du pokémon à ajouter</legend>
            <p>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom" value="" placeholder="Nom"\>

                <label for="categorie">Catégorie : </label>
                <input type="text" name="categorie" id="categorie" value="" placeholder="Catégorie"\>

                <label for="generation">Génération : </label>
                <input type="text" name="generation" id="generation" value="" placeholder="generation"\>

                <label for="taille">Taille : </label>
                <input type="text" name="taille" id="taille" value="" placeholder="taille"\>

                <label for="poids">Poids : </label>
                <input type="text" name="poids" id="poids" value="" placeholder="poids"\>

                <label for="pv">Pv : </label>
                <input type="text" name="pv" id="pv" value="" placeholder="pv"\>

                <label for="attack">Attaque : </label>
                <input type="text" name="attack" id="attack" value="" placeholder="attack"\>

                <label for="def">Défense : </label>
                <input type="text" name="def" id="def" value="" placeholder="def"\>

                <label for="vit">Vitesse : </label>
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
                <label for="image_poke">Téléchargez une image (regular) : </label>
                <input type="file" name="image_poke" id="image_poke" value=""/>

                <label for="image_poke_shiny">Téléchargez une image (shiny) : </label>
                <input type="file" name="image_poke_shiny" id="image_poke_shiny" value=""/>
            </p>
        </fieldset>
        <p class="center"><input type="submit" value="Ajouter"/> <input type="reset" value="Effacer les champs"/></p>
    </form>
</div>

<?php
// Testons si le fichier a bien été envoyé et s'il n'y a pas des erreurs
if (isset($_FILES['image_poke']) && $_FILES['image_poke']['error'] === 0 && isset($_FILES['image_poke_shiny']) && $_FILES['image_poke_shiny']['error'] === 0) {
    // Testons, si le fichier est trop volumineux
    if ($_FILES['image_poke']['size'] > 1000000 or $_FILES['image_poke_shiny']['size'] > 1000000) {
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
    $path_bdd = '/images/'. basename($_FILES['image_poke']['name']);
    $path_bdd_shiny = '/images/'. basename($_FILES['image_poke_shiny']['name']);
    $new_path = $path . basename($_FILES['image_poke']['name']);
    $new_path_shiny = $path . basename($_FILES['image_poke_shiny']['name']);

    // On peut valider le fichier et le stocker définitivement
    move_uploaded_file($_FILES['image_poke']['tmp_name'], $new_path);
    move_uploaded_file($_FILES['image_poke_shiny']['tmp_name'], $new_path);
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

    $requete = $bdd->prepare('INSERT INTO pokemon (nom, id_categorie, path_to_image, path_to_image_shiny, taille, poids, pv, attack, vitesse, defense) VALUES (:nom, :categorie, :path, :path_shiny,  :taille, :poids, :pv, :attack, :vitesse, :defense)');
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
    $requete->execute();

    $id_new_poke = $bdd->lastInsertId();

    $requete = $bdd->prepare("INSERT INTO link_generation(id_pokemon, id_generation) VALUES (:id_poke, :id_generation)");
    $requete->bindValue(':id_poke', $id_new_poke);
    $requete->bindValue(':id_generation', $_POST['generation']);
    $requete->execute();
    debug($_POST['types']);
    debug($_POST['faiblesses']);

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
        echo $id_type;

        $requete = $bdd->prepare("INSERT INTO link_faiblesse(id_type, id_pokemon) VALUES (:id_type, :id_pokemon)");
        $requete->bindValue(':id_type', $id_type);
        $requete->bindValue(':id_pokemon', $id_new_poke);
        $requete->execute();

    }

}
