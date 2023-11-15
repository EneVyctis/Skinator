## Important

Notice that this little web app is a 25 hours student project. The main objective of this project : learning php with symfony.
Hence, I do **not** garantee the security of the app.


## Lancer le projet

cd /tmp
unzip the .zip file
cd into the file
- rm -fr composer.lock symfony.lock vendor/ var/cache
- symfony composer install
- symfony server:start


### Weaponator (un jour ce nom changera...)

Le but de cette application, si elle venait à être finaliser, serait d'être dédier à un jeu (mmorpg) en particulier et permettrait de créer et de publier des équipements pour certaines tranches de niveau etc... 

Chaque membre possèderait un inventaire(**wardrobe**) avec tout les équipements du jeu, il pourrait créer des inventaires selon ses souhaits avec une selection des items du jeux, pour par exemple simuler son inventaire dans le jeu ou autre. 

La **wardrobe** possède:
- un id
- un nom
- une description
- des **weapons**
- un propriétaire



Les galleries(**showcases**) seraient alors les équipements créér que l'on peut publier pour aider d'autres personnes de la communauté ou bien les garder pour soit en privé. 

La **showcase** possède:
- un id
- un nom
- une description
- un booléen "isPublic"
- un créateur
- des **weapons**


Enfin, les objets(**weapons**), leur nom parlent d'eux mêmes.

Les **weapons** possèdent:
- un id
- un nom
- une rareté
- des **showcases**


Pour les membres/users, 4 sont chargés pas les données de test :

**possède les droits user**  
email: jonathan@localhost  
mdp :  jonathan  
**Jonathan** n'en possède qu'une seule nommée "My stands"  

email: michel@localhost  
mdp :  michel  
**Michel** possède deux showcases, une publique nommée "Show me your moves" et une privée nommée "Bigbox".  

email: user  
mdp :  user  
**User** ne possède rien  

**possède les droits admin**  
email: admin  
mdp :  admin  
**Admin** ne possède rien  

### Important : les différentes limitations mises en place

La page des membres est accessible à tout membre authentifié.

La page des [galeries] est accessible à tous, mais il faut être connecté pour en voir le contenue. 


Concrètement, un utilisateur n'a accès qu'à ce qu'il possède et aux [galeries] publiques des autres membres. Normalement tout ce dont il n'a pas accès n'est pas affiché sur ses pages. 

L'administrateur lui,a accès à tout en consultation MAIS ne possède pas les droits d'éditions en front office. Il faudra passer par le back office si des modifications sont à prévoir. 

### Comment tester les fonctionnalités

La page membre et les actions "show" sont la porte d'entrée vers toutes les autres consultations. 
La page "showcases" permet de lister et de consulter toutes les [galeries] publiques. 

Pour tester rapidement, prendre le profil **admin** et tester la consultation des inventaires/galeries/weapons. 
Ensuite, prendre **Jonathan**, constater que les inventaires de Michel n'apparaissent pas sur la page membre (normal). Tester eventuellement les galeries.
Ensuite aller sur la page de Jonathan et tester les formulaires (ajout d'inventaire, ajout de galerie, création d'un objet...). 
Enfin (pas forcément nécessaire), se connecter sur "user" pour voir ce que voit un profil vierge. 


1)

La consultation des objets se fait via les **showcases** publiques, il suffit de cliquer sur la **weapon** voulu pour être dirigé sur la page de celle ci. 

La consultation des objets via les inventaires est également possible mais **Attention : les wardrobes[inventaires] sont limités en consultation au propriétaire ou aux admins, utilisés donc le compte admin ou michel/jonathan pour tester**

La création des objets via l'inventaire est possible (encore une fois uniquement pour le propriétaire). 

2)

En plus de ne pas apparaître, la majorité des routes sont protégés (mis à part celles de consultation des [objets]). 

Possibilité de tester les routes 
/showcase/2 -> showcase privée 

/wardrobe/{id} avec id = 1 ou 2
Protection des inventaires. 

/showcase/3/edit -> edition bloquée

**Important, une erreur peut également apparaître si le propriétaire lui même essaie d'éditer via le formulaire. Celà provient d'un bug avec la version php utilisée, CEPENDANT, le formulaire fonctionne quand même (si vous voulez tester), juste une erreur apparaît en bas de page**

