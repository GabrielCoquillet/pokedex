<h1>Compte rendu</h1>
<h2 class="compte_rendu">I - Objectif</h2>
<p>
    Ce projet a pour but de concevoir une interface web fonctionnelle permettant de gérer une base de données de Pokémon. Sur ce site, il sera possible de lister, rechercher un Pokémon à l’aide de son prénom ou de ses caractéristiques et d’ajouter un Pokémon. De plus, nous l’avons hébergé chez OSDPROTECT, pour pouvoir y accéder vous pouvez aller sur le site <a href="https://pokedex.gcoquillet.fr" class="compte_rendu">pokedex.gcoquillet.fr</a>.
</p>
<h2 class="compte_rendu">II - Outils</h2>
<p>
    Pour réaliser ce projet, nous avons utilisé le langage de balisage HTML/CSS pour structurer et styliser l'interface utilisateur, le langage de programmation PHP pour la gestion des interactions entre l'utilisateur et le serveur, le langage de requête structurée SQL pour manipuler la base de données, le logiciel UwAmp comme environnement de développement local (serveur Apache/MySQL) et enfin le site GitHub pour collaborer entre nous.
</p>
<h2 class="compte_rendu">III - Base de données</h2>
<h3>Création de la base de données</h3>
<p>
    La base de données que nous avons créée contient 8 tables : pokemon, famille, link_region, region, link_type, type, link_faiblesse et categorie.
</p>
<p>
    La table Pokémon contient toutes les informations liées au Pokémon qui sont unique.
</p>
<p>
    La table famille permet de mettre en lien les id des différents Pokémon formant une famille.
</p>
<p>
    La table region contient toutes les régions de l’univers Pokémon.
</p>
<p>
    La table type contient tous les types de Pokémon existants.
</p>
<p>
    La table categorie contient toutes les catégories de Pokémon existantes.
</p>
<p>
    La table link_region permet de lier l’id d’un Pokémon avec l’id d’une région lorsque le Pokémon possède une forme régionale.
</p>
<p>
    Les tables link_faiblesse et link_type permettent de lier l’id d’un Pokémon aux ids de ses types et de ses faiblesses.
</p>
<h3>Schéma relationnel</h3>
<p>
    Pour faire ce schéma relationnel, nous avons utilisé SQL Designer, ce qui nous a permis d’avoir un code XML que vous pouvez retrouver dans le fichier ‘bdd_schematic.xml’.
</p>
<img src="images/shema.png" alt="shéma relationnel" class="compte_rendu"/>
<h3 id="peuplement">Peuplement de la base</h3>
<p>
    Pour pouvoir peupler la base nous avons utilisé un fichier json contenant les caractéristiques de 1025 Pokémon, que nous avons extrait du site Tyradex via son api. Au début, nous avions testé avec quelques Pokémon pour vérifier que cela fonctionnait, puis nous avons utilisé l’API de Tyradex avec un script en python qui nous a permis d’ajouter tous les autres Pokémon dans la base de données de manière automatisée. Vous pouvez retrouver ce code dans le fichier peuplement.py.
</p>
<p>
    Pour récupérer les informations des Pokémon via l’API de Tyradex, nous avons utilisé la fonction get() du module python requests afin d’effectuer la requête à l’api. Par la suite, nous devons définir le type de données reçues par la requête avec l'instruction data = data.json() : data peut maintenant être parcourue comme un tableau dynamique de dictionnaires python.
</p>
<h2 class="compte_rendu">IV - Développement de l'interface</h2>
<h3>config.php</h3>
<p>
    Ce fichier permet de se connecter à la base de données, à l’aide d’un identifiant et d’un mot de passe déjà défini dans des variables.Pour ce faire, nous utilisons le module php PDO. De plus, l’instruction error_reporting nous permet d’afficher les erreurs php si jamais il y en a afin de pouvoir y remédier. Enfin, la fonction debug nous permet d’afficher le contenu d’une variable, d’un array ou de tout élément qui lui est donné en paramètre, permettant facilement de vérifier le bon fonctionnement de notre code lorsqu’on le souhaite.
</p>
<h3>index.php</h3>
<p>
    Cette page est la page d’accueil de notre site, c’est la page principale. Elle a pour but d’afficher le menu et d’insérer à sa suite la bonne page en fonction du paramètre a qui est communiqué via la méthode GET de php. Par exemple : si aucune action n’est réalisée, la page insèrera lister.php, qui permet d’afficher toutes les occurrences de notre base de données. Le menu est dynamique : l’onglet correspondant à la page insérée est mis en couleur afin de permettre à l’utilisateur de savoir facilement et rapidement où il se situe sur le site.
</p>
<h3>lister.php</h3>
<p>
    Lister.php permet d’afficher sous forme de tableau html les Pokémon contenus dans une instance de l’objet PDOStatement $réponse. Cette variable est définie dans les autres fichiers faisant appel à lister.php pour plus de modularité. Cela nous permet de ne pas avoir à recopier son code dans chaque page où on souhaite lister des Pokémon mais juste de l’appeler avec les données déjà prédéfinies.
</p>
<p>
    Afin d’afficher toutes les occurrences contenues dans $réponse, nous avons créé une while qui, à chaque tour de boucles, définit l’array données contenant les information du Pokémon à l’aide de la méthode fetch() de la classe PDOStatement
</p>
<p>
    Par la suite, on affiche les différentes caractéristiques de chaque Pokémon à l’aide d’autres requêtes SQL nous permettant d’obtenir les types et faiblesses du Pokémon, mais aussi ses évolutions, sa variante régionale s’il en possède une et sa génération d’apparition.
</p>
<h3>rechercher.php</h3>
<p>
    Cette page permet de rechercher un Pokémon dans la base de données. Pour cela de nombreux critères de recherche sont disponibles tels que la recherche par nom, par id, par type ou faiblesse, par génération ainsi que par catégorie.
</p>
<p>
    Afin de pouvoir choisir le critère de recherche, nous avons utilisé un formulaire html avec pour méthode POST, une balise select et des balises options, nous permettant d’afficher un menu déroulant avec les différents critères de recherche ainsi qu’une balise input pour le contenu de la recherche.
</p>
<p>
    Par la suite, on exécute la requête sql pour retrouver le ou les Pokémon en fonction du critère et du contenu de la recherche, on l'exécute et l'attribue à $reponse puis on insère lister.php afin d’afficher le résultat de la recherche.
</p>
<h3>ajouter.php</h3>
<p>
    Cette page permet à l’utilisateur d’ajouter un nouveau Pokémon via un formulaire html. Les balises input nous permettent de renseigner les informations du Pokémon mais également d’importer des images depuis l’ordinateur du client pour ce Pokémon.
</p>
<p>
    Afin de renseigner les types et les faiblesses du Pokémon, nous avons dû créer un menu déroulant permettant de sélectionner plusieurs occurrences. Pour cela, nous avons créé une div contenant plusieurs input de type checkbox avec pour nom types[], nous permettant d'accéder aux différents types sélectionnés via un array php qui apparaît à l’aide d’un bouton html lorsque ce dernier est survolé.
</p>
<p>
    Une fois les informations renseignées et le bouton ‘Ajouter’ cliqué, des requêtes sql d’insertion sont effectuées afin d’ajouter le Pokémon dans la base de données et une fois ces requêtes terminées, le nouveau Pokémon est affiché en insérant lister.php .
</p>
<h3>rendu.php</h3>
<p>
    Ce fichier permet d’afficher le compte rendu directement dans le site. Cela permettra à tous les utilisateurs de ce site de comprendre comment on a procédé à la création de ce site.
</p>

<h2 class="compte_rendu">V - Difficultés rencontrées</h2>
<h3>Peuplement de la base de données</h3>
<p>
    Pour peupler notre base de données, nous devions ajouter à la main les 1025 Pokémon existants ainsi que leurs images et leurs spécifications. Pour pallier cela, nous avons recherché des alternatives afin de faciliter la tâche. Nous avons donc trouvé l’API Tyradex nous permettant en une requête http de récupérer l’entièreté des Pokémon et de leurs spécifications. Ainsi, nous avons utilisé cette api avec un script python afin de peupler notre base de données comme mentionné dans <a href="#peuplement" class="compte_rendu">Peuplement de la base</a>
</p>
<h3>Problème de caractères spéciaux</h3>
<p>
    Lors du peuplement de la base, certaines erreurs sont apparues lors de l’insertion des informations de Pokémon sur la base de données. Ce problème était lié au nom de certains Pokémon qui contiennent des caractères non supportés par la base de données. Nous avons donc créé un fonction tri(nom:str)->str, permettant de pallier ce problème.
</p>
<h3>Chargement des images</h3>
<p>
    Lorsqu’on va sur le site, on s’est rendu compte que les images prenaient beaucoup de temps à apparaître. En effet, il y a près de 2030 images de Pokémon et ces dernières étaient stockées sur le github de l’API Tyradex. Par conséquent, le chargement des images était plutôt lent. Pour remédier à cela, nous avons téléchargé les images puis les avons importées dans le dossier images du site afin d’accélérer le temps de chargement de ces dernières.
</p>
<p>
    Dorénavant, le site met environ 5 secondes à charger les 2000 images au lieu d’une quinzaine.
</p>
<h3>Importation des images</h3>
<p>
    Sur la version locale avec Uwamp, l’importation des images ne rencontrait aucun souci. Cependant, sur le site hébergé en ligne, aucune erreur n’était mentionnée mais l’image n’était en fait pas importée sur le site. Cela était en fait dû aux droits d'accès du dossier  images sur le serveur web et à la taille maximale du fichier définie dans ‘ajouter.php’.
</p>
