<!-- contenu de la page rechercher -->
<h1>Ajouter une BD</h1>
<div class="formulaire">
    <form action="index.php?a=ajouter" method="post">
        <fieldset>
            <legend>Informations du pokémon à ajouter</legend>
            <p>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom" value="" placeholder="Nom"\>
                <label for="auteur">Auteur : </label>
                <input type="text" name="auteur" id="auteur" value="" placeholder="Auteur"\>
            </p>
            <p>
                <label for="image_poke">Téléchargez une image : </label>
                <input type="file" name="image_poke" id="image_poke" value=""/>
            </p>
        </fieldset>
        <p class="center"><input type="submit" value="Lister"/> <input type="reset" value="Effacer les champs"/></p>
    </form>
</div>