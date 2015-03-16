# Bundle d'upload pour Symfony2
En cours de développement...

## Présentation
Ce bundle vous permettra d'ajouter des champs d'upload en ajax dans vos formulaires.  
[Basé sur le plugin d'upload blueimp/jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload)

## Installation
Via Composer (A venir)

## Configuration
Ajouter le bundle à votre kernel

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Bnbc\UploadBundle\BnbcUploadBundle(),
    // ...
);
```

Ajouter les fichiers javascripts à votre template, supprimer la ligne avec jQuery si vous l'avez déjà (requiert jQuery 1.6+).  

```twig
{% javascripts 
	'@BnbcUploadBundle/Resources/public/js/1_jquery.min.js'
	'@BnbcUploadBundle/Resources/public/js/2_jquery.ui.widget.js'
	'@BnbcUploadBundle/Resources/public/js/3_jquery.iframe-transport.js'
	'@BnbcUploadBundle/Resources/public/js/4_jquery.fileupload.js'
	'@BnbcUploadBundle/Resources/public/js/5_init.js' %}
	<script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %} 
```  
      
Ajouter la route

```yaml
# app/config/routing.yml

bnbc_upload:
    resource: "@BnbcUploadBundle/Controller/"
    type:     annotation
    prefix:   /upload
```

## Options de configuration globale (facultatives)

### max\_file\_size  
Taille de fichier max en octets  
Défaut: `null` (la limite dépendra alors des variables `upload_max_filesize` et `post_max_size` de votre php.ini)  
Exemple: 10 * 1024 * 1024 = 10485760 représente (10 Mo)

### accept\_file\_types  
Expression régulière pour gérer les fichiers ou types de fichiers acceptés  
Défaut: `'/.+$/i'` (Autorise tous les fichiers)  
Exemple: `'/\.(gif|jpe?g|png)$/i'` (Autorise uniquement les fichiers images gif, jpeg et png)

### upload\_folder
Dossier de téléversement des fichiers par rapport à la racine du dossier web  
Défaut: `'uploads'`  
Exemple: `'uploads/test'` (Il est possible d'indiquer des sous-dossiers, ils se créeront automatiquement)

```yaml
# app/config/config.yml

bnbc_upload:
    max_file_size: null
    accept_file_types: '/.+$/i'
    upload_folder: 'uploads'
```

## Utilisation

Ajouter un champs de type `bnbc_ajax_file` à votre formulaire

```php
$formBuilder->add('myfield', 'bnbc_ajax_file');
```

## Options de configuration du champs fichier (facultatives)

### multiple
Téléversement de plusieurs fichiers en même temps  
Défaut:  `false`
### autoUpload
Le(s) fichier(s) se téléverse(nt) automatiquement après avoir été ajouté, si `false` un bouton de soumission apparait.  
Défaut:  `true`
### dropZone
Affichage d'une zone de glisser/déposer  
Défaut:  `true`
### dropzoneText
Texte la zone de glisser/déposer  
Défaut:  `'Drop file(s) here'`

```php
$formBuilder->add('myfield', 'bnbc_ajax_file', 
	array(
        'multiple'      => false,
        'autoUpload'    => true,
        'dropZone'      => true,
        'dropzoneText' => 'Drop file(s) here',
	)
);
```

Vous pouvez redéfinir les options de configuration globale pour chaque champs dans le paramètre formData

```php
$formBuilder->add('myfield', 'bnbc_ajax_file', 
	array(
        'formData'     => array(
            'max_file_size'     => 5 * 1024 * 1024,
            'accept_file_types' => null,
            'upload_folder'     => 'test', 
        ),
	)
);
```
