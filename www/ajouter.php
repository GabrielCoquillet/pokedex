		<!-- contenu de la page rechercher -->
			<h1>Ajouter une BD</h1>
			<div class="formulaire"> 
				<form action="index.php?a=ajouter" method="post">
					<fieldset>
						<legend>Informations de la BD à ajouter</legend>
						<p>
							<label for="titre">Titre : </label>
							<input type="text" name="titre" id="titre" value="" placeholder="Titre"\>
							<label for="auteur">Auteur : </label>
							<input type="text" name="auteur" id="auteur" value="" placeholder="Auteur"\>
						</p>
						<p>
							<label for="image_bd">Téléchargez une image : </label>
							<input type="file" name="image_bd" id="image_bd" value=""/>
						</p>
					</fieldset>
					<p class="center"><input type="submit" value="Lister"/> <input type="reset" value="Effacer les champs"/></p>
				</form>
			</div>