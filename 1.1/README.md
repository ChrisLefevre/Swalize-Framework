# [Swalize CMS](http://swalize.com/) 1.1

### Mise à jour 

## Ajout du block de type separation pour models.php
```php
'sp_seo' => array(
'label' => ’Titre de cet espace’,
'type' => 'separation'
),
```

## Ajout d’une valeur height pour les textarea de models.php
```php
'sub_baseline' => array(
'label' => ‘Mon texte’,
'type' => 'textarea',
'placeholder' => 'Un site cool pour tout le monde',
'height'=> 60
),
```

## Ajout des fonctions :
```php
$sw->cmsInfos();  // pour afficher le temps de génération de la page en commentaire

$sw->hide_email($email);  // pour cacher une adresse email des moteurs de recherches.
```

## Pour le plugin de contact form :  exemple d'un formulaire écrit directement en HTML.

## Corrections divers
