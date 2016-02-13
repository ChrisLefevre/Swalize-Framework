# [Swalize CMS](http://swalize.com/) 1.0

Développez en PHP5, ce CMS est réalisé pour répondre à un besoin simple de rapidité et flexibilité. Il permet de créer un site vitrine d’entreprise multilingue rapidement. Plutôt que d’utiliser une Base de donnée relationnelle ou un nosql. Ce CMS dispose de son propre moteur de DB orienté Document JSON.

Il permet également de créer une administration évolutive.

Swalize Framework est également un CMS avec des fonctionnalités classiques mais il fonctionne de façon peu conventionnelle. Son admin se customise avec un tableau. Vous pouver créer votre site et ensuite vous définir des zones éditables.

Il est totalement indiqué pour des sites responsive Bootstrap, et se montre beaucoup plus efficace que Wordpress pour les sites onepage multilingue.

## Swalize-Framework est également une base que vous pouvez faire évoluer vous même.

*   Il permet de créer facilement des sites multilingues
*   IL supporte les plugins
*   Il pensé pour les sites onepage ou multipage dont la structure ne bouge pas.
*   Il dispose de fonction de publication d’article avec des champs customisables.
*   Il peut gérer un portfolio ou un catalogue de produit.
*   Il peut sauvegarder les mails envoyé depuis le formulaire de contact.
*   Il n’est pas optimisé pour les gros sites avec beaucoup de contenu.
*   Il fonctionne sans base de donnée mais les données sensibles peuvent être encryptées.
*   Il peut être efficace comme admin simple pour paramétres à distance des apps iOS et Android car il génère des données au format Json.

Et évidemment, il sera régulièrement mis à jour sur Github.

## Comment débuter?

C’est très simple.

### Editez le fichier ./sw-admin/controls/models.php

-> modifiez secure_key , cette clé encrypte les DB. Si vous la modifiez, vous perdez vos données mais les blocks et articles resteront disponibles.

-> Définissez les langues,

-> Définissez votre structure de donnée.

### connectez vous sur ./sw-admin/

user: admin@swalize.com

pass: root

Créez un nouvel utilisateur admin et supprimez le compte Root.

Pensez à modifier « Site URL » dans l’éditeur.

## Le fichier models.php : Les options

Ce document est le couteau suisse du CMS. C’est dans ce document que vous pourrez structurer l’admin du site.

### Options ($swcnt_options)

_Ajouter ou enlevez une langue_
```php
    'languages' => array(
        'fr',
        'en'
    ) ,
```
_Définir de nouvelle langues_
```php
‘languages_names’ => array(

        'fr' => "Français",
        'en' => "English",
        'nl' => "Nederlands",
        'de' => "Deutsch"
    ) ,
```
_La Clé de sécurité doit être modifiée avant de commencer_

    'secure_key' => ‘xxx765abc54’,

_Passez sur False si le serveur ne supporte pas l’URL Rewriting_

    'urlrewriting' => true,

_Ce n’est pas obligatoire mais vous pouvez ajoutez votre adresse email_

    'contact_email' => '',

_Si activée, cette fonction peut poser des problèmes de compatibilité._

    'crypt' => 0,

_Ici, vous pouvez activer les fonctions de blogging mais également ajouter un catalogue de produit ou un portfolio. A l’usage, ces 3 outils se comportent de façon identiques mais vous pouvez les configurer individellement_

    'blog' => 1,
    'catalog' => 0,
    'portfolio' => 0

### Plugins ($swcnt_plugins)

_liste des plugins. Ajouter contact form peut être utile_

    ‘contact_form’, 

## Le fichier models.php : La structure de données

L’admin du site se construit avec des « blocks » qui sont simplement des tableaux en PHP. Il est donc très facile d’ajouter un champ ou un éditeur wysiwyg dans l’administration du site. Le contenu du champ pourra être récupéré aisément sur le site.

### $swcnt_tree

Le tableau $swcnt_tree contient les pages de l’espace « Editeur ». Vous pouvez créer facilement l’administration d’une page d’accueil, du footer.

Ajouter ce tableau permet de créer la page Popol dans l’admin.
```php
    $swcnt_tree[‘popol’] = array(
<<<<<<< Updated upstream
=======

        ’sw_title’ => ‘Page de Popol’,

        ’sw_blocks’ => array(

    	)
    );
```

Le « block » suivant est utilisé pour gérer la page d’infos du site. Chaque block est un champ dans la DB. 

Les différents types de champs sont :

* input_txt
* textarea
* htmlarea -> éditeur wysiwyg summernote
* blogarea -> éditeur wysiwyg tinymce
* select
* checkbox
* tags
* picture -> un bouton pour télécharger une photo.
* list -> permet de créer une sous-liste de champs en tableau. Pratique pour créer un album photos ou la navigation du site.
>>>>>>> Stashed changes

        ’sw_title’ => ‘Page de Popol’,

        ’sw_blocks’ => array(

    	)
    );
```

Le « block » suivant est utilisé pour gérer la page d’infos du site. Chaque block est un champ dans la DB. 

Les différents types de champs sont :

* input_txt
* textarea
* htmlarea -> éditeur wysiwyg summernote
* blogarea -> éditeur wysiwyg tinymce
* select
* checkbox
* tags
* picture -> un bouton pour télécharger une photo.
* list -> permet de créer une sous-liste de champs en tableau. Pratique pour créer un album photos ou la navigation du site.

