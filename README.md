# [Swalize LightCms](http://swalize.com/) 0.01 beta

Ce CMS est réalisé pour répondre à un besoin simple de rapidité. Il permet de créer un site vitrine d’entreprise multilingue rapidement sans base de donnée. Il permet également de créer une administration évolutive. 

Il fonctionne de façon inversée. Vous créez d’abord votre site, et ensuite vous définissez des zone éditable sur celui-ci. Il ne permet donc pas créer des pages à la volée.

## C’est une base que vous pouvez faire évoluer vous même.  

* Il permet de créer facilement des sites multilingues
* Il pensé pour les sites onepage ou multipage dont la structure ne bouge pas.
* Il dispose de fonction de blogging.
* Il peut sauvegarder les mails envoyé depuis le formulaire de contact.
* Il n’est pas optimisé pour les gros sites avec beaucoup de contenu.
* Il fonctionne sans base de donnée mais les données sensibles sont encryptées.    
 

     

## Comment débuter? 

### Editez le fichier ./sw-admin/controls/models.php 
-> modifiez  secure_key , cette clé encrypte les DB.  Si vous la modifiez, vous perdez vos données mais les blocks et articles resteront disponibles.

-> Définissez les langues,
-> Définissez votre structure de donnée. 

### connectez vous sur ./sw-admin/

user: admin@swalize.com 
pass: root

Créez un nouvel utilisateur admin et suprimmer le compte Root.



## Createur

Christophe Lefevre. 
Belge. Rédacteur de [Techtrends](http://techtrends.eu/) 



