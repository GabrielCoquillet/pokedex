<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link rel="icon" type="image/png" href="" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include("config.php"); ?>
<!-- titre -->
<div id="div_titre">
    <h1>Pokedex</h1>
</div>
<div class="clear"></div>

<!-- menu -->
<div id="menu">
    <ul id="onglets">
        <li><a href="index.php?a=lister">Liste des Pokémons</a></li>
        <li><a href="index.php?a=rechercher">Rechercher un Pokémon</a></li>
        <li><a href="index.php?a=ajouter">Ajouter un Pokémon</a></li>
    </ul>
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

