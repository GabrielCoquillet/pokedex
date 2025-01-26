<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link rel="icon" type="image/png" href="images/pokedex.jpeg" />
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
</head>

<body>
<?php include("config.php");
//menu dynamique
if (isset($_GET['a'])){
    $class_lister = '';
    $class_ajouter = '';
    $class_rechercher = '';
    $class_rendu = '';
    //on définit les classes des boutons du menu en fonction de a pour savoir lequel est actif
    if ($_GET['a'] == "ajouter"){
        $class_ajouter = 'class="actif"';
    }elseif ($_GET['a'] == "rendu"){
        $class_rendu = 'class="actif"';
    }elseif ($_GET['a'] == "rechercher"){
        $class_rechercher = 'class="actif"';
    }else{
        $class_lister = 'class="actif"';
    }
}
else{
    $class_ajouter = '';
    $class_rechercher = '';
    $class_rendu = '';
    $class_lister = 'class="actif"';
}
//on affcihe le menu avec la classe actif pour l'onglet actif afin qu'il soit affiché en couleur
echo '<!-- menu -->
<div class="menu">
    <!-- titre -->
    <a class="logo" href="index.php">Pokedex</a>
    <div class="menu-droit">
        <a '.$class_lister.' href="index.php?a=lister">Lister</a>
        <a '.$class_rechercher.' href="index.php?a=rechercher">Rechercher</a>
        <a '.$class_ajouter.' href="index.php?a=ajouter">Ajouter</a>
        <a '.$class_rendu.' href="index.php?a=rendu">Compte rendu</a>
    </div>
</div>';
?>



<!-- contenu de la page -->
<div id="contenu">
    <?php
    //orientation vers la bonne page
    if (isset($_GET['a']) && !empty($_GET['a'])) {
        //Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
        $action = (!empty($_GET['a'])) ? $_GET['a'].'.php' : 'index.php';

        // Si l'action existe, on l'exécute
        if (is_file($action)) {
            if ($_GET['a'] == 'lister') {
                //on execute la requête à la bdd pour obtenir tous les pokémon
                $reponse = $bdd->query('SELECT * FROM pokemon');
            }
            include $action;
            // Sinon, on affiche la page d'index du module !
        }
    // Module non specifié ou invalide ? On affiche la page d'accueil !
    }
    else {
        //on execute la requête à la bdd pour obtenir tous les pokémon
        $reponse = $bdd->query('SELECT * FROM pokemon');
        include 'lister.php';
    }
    ?>
</div>

<!-- Pied de page -->
<div id="footer">
    Jallet Kishokumar Coquillet Janvier 2025
</div>
</body>
</html>

