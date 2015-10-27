# [Swalize Framework](http://swalize.com/) 0.02 

Ce Frameworks CMS est réalisé pour répondre à un besoin simple de rapidité et flexibilité. Il permet de créer un site vitrine d’entreprise multilingue rapidement. Plutôt que d'utiliser une Base de donnée relationnelle ou un nosql. Ce framewoks dispose de son propre moteur de DB orienté Document JSON.  Il permet également de créer une administration évolutive.

Swalize Framework est égalemen un CMS avec des fonctionnalités classiques mais il fonctionne de façon inversée. Vous créez d’abord votre site, et ensuite vous définissez des zone éditable sur celui-ci. Il ne permet donc pas créer des pages à la volée.

Il est totalement indiqué pour des sites responsive Bootstrap, et se montre beaucoup plsu efficace que Wordpress pour les sites onepage multilingue.  

## Swalize-Framework est également une base que vous pouvez faire évoluer vous même.  

* Il permet de créer facilement des sites multilingues
* Il pensé pour les sites onepage ou multipage dont la structure ne bouge pas.
* Il dispose de fonction de blogging.
* Il peut sauvegarder les mails envoyé depuis le formulaire de contact.
* Il n’est pas optimisé pour les gros sites avec beaucoup de contenu.
* Il fonctionne sans base de donnée mais les données sensibles peuvent être encryptées.    

Je publierai régulièrement des mises à jour et des nouveaux modules sur Github.  
     

## Comment débuter? 

### Editez le fichier ./sw-admin/controls/models.php 
-> modifiez  secure_key , cette clé encrypte les DB.  Si vous la modifiez, vous perdez vos données mais les blocks et articles resteront disponibles.

-> Définissez les langues,
-> Définissez votre structure de donnée. 

### connectez vous sur ./sw-admin/

user: admin@swalize.com 
pass: root

Créez un nouvel utilisateur admin et suprimmez le compte Root.



## Createur

Christophe Lefevre. 
Belge. Rédacteur de [Techtrends](http://techtrends.eu/) 



