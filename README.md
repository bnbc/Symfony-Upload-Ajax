# Bundle d'upload pour Symfony2
En cours de développement...

## Présentation
Ce bundle vous permettra d'ajouter des champs d'upload en ajax dans vos formulaires.  
Par défaut le fichier s'upload automatiquement et son nom est attribué à la valeur du champs caché correspondant.  
[Basé sur le plugin d'upload blueimp/jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload)

## Installation
Via Composer

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

Ajouter les fichiers javascripts à votre template, supprimer la ligne avec jQuery si vous l'avez déjà (requiert jQuery 1.6+)
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

Ajouter les options de configuration globale (non obligatoire)
```yaml
# app/config/config.yml

bnbc_upload:
    max_size: 5120k
    mime_types: ['audio/wav', 'audio/x-wav', 'audio/wave', 'audio/x-pn-wav']
    upload_folder: uploads # Dans le dossier web
```

## Utilisation

Ajouter un champs de type `bnbc_ajax_file` à votre formulaire
```php
$formBuilder->add('myfield', 'bnbc_ajax_file');
```

Vous pouvez redéfinir les options de configuration globale pour chaque champs
```php
$formBuilder->add('myfield', 'bnbc_ajax_file', 
	array(
		'max_size' => '5120k',
		'mime_types' => array('audio/wav', 'audio/x-wav', 'audio/wave', 'audio/x-pn-wav'),
		'upload_folder' => 'uploads',
	)
);
```
