<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link rel="icon" type="image/png" href="" />
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
</head>

<body>
<?php include("config.php"); ?>

<!-- menu -->
<div class="menu">
    <!-- titre -->
    <a class="logo">Pokedex</a>
    <div class="menu-droit">
        <a href="index.php?a=lister">Lister</a>
        <a href="index.php?a=rechercher">Rechercher</a>
        <a href="index.php?a=ajouter">Ajouter</a>
        <a href="index.php?a=rendu">Compte rendu</a>
    </div>
</div>

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
                $reponse = $bdd->query('SELECT * FROM pokemon');
            }
            include $action;
            // Sinon, on affiche la page d'index du module !
        }
        // Module non specifié ou invalide ? On affiche la page d'accueil !
    }
    else {
        $reponse = $bdd->query('SELECT * FROM pokemon');
        include "lister.php";
    }
    ?>
</div>

<!-- Pied de page -->
<div id="footer">
    Jallet Kishokumar Coquillet Décembre 2024
</div>
</body>
</html>

