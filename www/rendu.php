<h1>Compte rendu</h1>
<h2>Objectif</h2>
<p>
    Ce projet a pour but de concevoir une interface web fonctionnelle permettant de gérer une base de données de Pokémon. Sur ce site il sera possible de lister, rechercher un pokémon à l’aide de son prénom ou de ses caractéristiques et d’ajouter un pokémon. De plus, nous l’avons hébergé, pour pouvoir y accéder vous pouvez aller sur le site pokedex.gcoquillet.fr .
</p>
<h2>Outils</h2>
<p>
    Pour réaliser ce projet, nous avons utilisé le langage de balisage HTML/CSS pour structurer et styliser l'interface utilisateur, le langage de programmation PHP pour la gestion des interactions entre l'utilisateur et le serveur, le langage de requête structurée SQL pour manipuler la base de données, le logiciel UwAmp comme environnement de développement local (serveur Apache/MySQL) et enfin le site GitHub pour collaborer entre nous.
</p>
<h2>Base de données</h2>
<h3>Création de la base de données</h3>
<p>
    La base de données que nous avons créée contient 10 tables : pokemon, famille, link_generation, generation, link_region, region, link_type, type, link_faiblesse et categorie.
</p>
<h3>Schéma relationnel</h3>
<p>
    Pour faire ce schéma relationnel, nous avons utilisé SQL Designer, ce qui nous a permis d’avoir un code XML que vous pouvez retrouver dans le fichier ‘bdd_schematic.xml’.
</p>
<h3>Peuplement de la base</h3>
<p>
    Pour pouvoir peupler la base, nous avons utilisé un fichier json contenant les caractéristiques de 1025 pokémon, que nous avions extrait du site Tyradex via son api. Au début, nous avions testé avec quelques pokémon pour vérifier que cela fonctionnait, puis nous avons utilisé l’API de Tyradex avec un script en python qui nous a permis d’ajouter tous les autres dans la base de données. Vous pouvez retrouver ce code dans le fichier peuplement.py .
</p>
<h2>Développement de l'interface</h2>
<h3>config.php</h3>
<p>
    Ce fichier permet de se connecter à la base de données, à l’aide d’un identifiant et d’un mot de passe déjà défini dans des variables. De plus, il est possible d’afficher les erreurs (en changeant le 0 en 1 ou 1 en 0 dans “error_reporting()”), et les variables et les requêtes utilisées (en appelant la fonction debug()).
</p>
<h3>index.php</h3>
<p>
    Cette page est la première page lorsque nous accédons au site, c’est la page principale. Elle a pour but d'orienter vers la bonne page. Par exemple : si aucune action n’est réalisée, la page ira vers la page lister.php.

</p>
<h3>lister.php</h3>
<p>
    Dans ce fichier, nous avons créé une grande boucle while qui, à chaque tour de boucles, affiche les différentes caractéristiques de chaque pokémon.  Cette page affiche un tableau avec tous les pokémon qui se trouve dans la base de données. Il sera possible de supprimer un pokémon à l’aide d’une bouton suppression qui se trouve dans la dernière colonne du tableau.

</p>
<p>
    La requête sql ‘SELECT * FROM pokemon’ nous permet d’obtenir la liste de tous les pokémons contenus dans la base de données afin de les traiter un par un. Plusieures autres requêtes sont également necessaires afin de pouvoir afficher les informations complémentaires du pokémon telles que ses types, ses faiblesses, ses évolutions, sa ou ses générations ainsi que ses formes régionales.

</p>
<h3>rechercher.php</h3>
<p>
    Cette page permet de rechercher un pokémon dans la base de données. Pour le retrouver, il y a beaucoup moyen possible, on peut renseigner le début ou la fin du nom du pokémon, son id, sa génération, sa catégorie, son type et sa faiblesse.

</p>
<h3>ajouter.php</h3>
<p>

</p>
<h3>rendu.php</h3>
<p>
    Ce fichier permet d’afficher le compte rendu directement dans le site. Cela permettra à tous les utilisateurs de ce site de comprendre comment on a procédé à la création de ce site.
</p>

<h2>Difficultés rencontrées</h2>
<h3>API</h3>
<p> Pour peupler notre base de données, nous avions besoin d’une API, mais on ne savait pas  comment l’utiliser donc on a dû faire des recherches pour trouver une API et pour comprendre comment ça fonctionne.
</p>
<h3>Caractères spéciaux</h3>
<p>Lors du peuplement de la base, on a eu un problème, on a eu une succession d'erreurs. Pour comprendre, on a regardé les noms des pokémon qu’il y avait dans la base, et on s’est rendu compte qu’il y avait des caractères spéciaux dans les noms des pokémon (comme "♀” et "♂”). Pour y remédier, nous avons créé une fonction tri() qui enlève ces caractères spéciaux dans les noms des pokémon.
</p>
<h3>Chargement des images</h3>
<p>Lorsqu’on va sur le site, on s’est rendu compte que les images prenaient beaucoup de temps à apparaître. En effet, il y a près de 2030 images de pokémons et ces dernières étaient stockées sur les serveurs de l’API Tyradex. Par conséquent, le chargement des images était plutôt lent. Pour remédier à cela, nous avons téléchargé les images puis les avons importées dans le dossier images du site afin d’accélérer le temps de chargement de ces dernières.
</p>
<h3>Importation des images</h3>
<p>Sur la version locale avec Uwamp, l’importation des images ne rencontrait aucun souci. Cependant, sur le site hébergé en ligne, aucune erreur n’était mentionnée mais l’image n’était en fait pas importée sur le site.
</p>