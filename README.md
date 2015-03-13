# Bundle d'upload pour Symfony2
En cours de développement...

## Présentation
Ce bundle vous permettra d'ajouter des champs d'upload en ajax dans vos formulaires.
[Basé sur le plugin d'upload blueimp/jQuery-File-Upload](https://github.com/blueimp/jQuery-File-Upload)

## Installation
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
Ajouter les fichiers javascripts à votre template, supprimer la ligne avec jQuery si vous l'avez déjà
```twig
{% javascripts 
	'@BnbcUploadBundle/Resources/public/js/2_jquery.ui.widget.js'
	'@BnbcUploadBundle/Resources/public/js/3_jquery.iframe-transport.js'
	'@BnbcUploadBundle/Resources/public/js/4_jquery.fileupload.js'
	'@BnbcUploadBundle/Resources/public/js/5_init.js' %}
	<script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %} 
```