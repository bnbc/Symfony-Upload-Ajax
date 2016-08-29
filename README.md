# Bundle d'upload pour Symfony2
Ce bundle vous permettra d'ajouter des champs d'upload en ajax dans vos formulaires.
<a href="https://github.com/blueimp/jQuery-File-Upload" target="_blank">Basé sur le plugin d'upload blueimp/jQuery-File-Upload</a>
## Installation via composer
Ajoutez le `require` à votre fichier composer.json et lancer la commande `composer update`

```yaml
# composer.json

{
    // ...
    require: {
        // ...
        "bnbc/upload-bundle": "dev-master"
    }
}
```

## Configuration
Ajoutez le bundle à votre kernel

```php
# app/AppKernel.php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Bnbc\UploadBundle\BnbcUploadBundle(),
    // ...
);
```
Copiez les assets situés dans le dossier `/vendor/bnbc/upload-bundle/Bnbc/UploadBundle/Resources/public/js` dans le dossier `/web/bundles/bnbc/upload` et ajoutez les fichiers javascripts à votre template, supprimez la ligne avec jQuery si vous l'avez déjà (requiert jQuery 1.6+).

```twig
<script src="{{ asset('bundles/bnbc/upload/1_jquery.min.js') }}"></script>
<script src="{{ asset('bundles/bnbc/upload/2_jquery.ui.widget.js') }}"></script>
<script src="{{ asset('bundles/bnbc/upload/3_jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('bundles/bnbc/upload/4_jquery.fileupload.js') }}"></script>
<script src="{{ asset('bundles/bnbc/upload/5_init.js') }}"></script>
```

Ajouter la route

```yaml
# app/config/routing.yml

bnbc_upload:
    resource: "@BnbcUploadBundle/Controller/"
    type:     annotation
    prefix:   /upload
```

Ajouter la ressource pour le type de champs `bnbc_ajax_file`

```yaml
# app/config/config.yml

twig:
    form:
        resources:
            - 'BnbcUploadBundle:Form:fields.html.twig'
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

### image\_versions
Génération de formats supplémentaires, 3 formats possibles: `thumbnail`, `medium`, `large`. Le paramètre `crop` permet de recadrer l'image à la taille indiquée
Défaut: `null`
Exemple:
```yaml
thumbnail:
    max_width: 100
    max_height: 100
    crop: true
medium:
    max_width: 300
    max_height: 300
    crop: false
large:
    max_width: 1024
    max_height: 768
    crop: false
```

### Exemple complet

```yaml
# app/config/config.yml

bnbc_upload:
    max_file_size: 10485760
    accept_file_types: '/\.(gif|jpe?g|png)$/i'
    upload_folder: 'uploads/test'
    image_versions:
        thumbnail:
            max_width: 100
            max_height: 100
            crop: true
        medium:
            max_width: 300
            max_height: 300
            crop: false
        large:
            max_width: 1024
            max_height: 768
            crop: false
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

### dropZoneText
Texte la zone de glisser/déposer
Défaut:  `'Drop file(s) here'`

### callbackFunction
Nom d'une fonction javascript à appeler une fois le téléversement terminé
Défaut:  `null`

### formData
Vous pouvez redéfinir les options de configuration globale pour chaque champs dans le paramètre formData
Défaut:  ne pas mettre le paramètre

```php
$formBuilder->add('myfield', 'bnbc_ajax_file',
    array(
        'multiple'          => false,
        'autoUpload'        => true,
        'dropZone'          => true,
        'dropZoneText'      => 'Drop file(s) here',
        'callbackFunction'  => null,
        'formData'          => array(
            'max_file_size'     => 5 * 1024 * 1024,
            'accept_file_types' => null,
            'upload_folder'     => 'test',
            'image_versions'    => array(
                'thumbnail' => array(
                    max_width  => 100
                    max_height => 100
                    crop       => true
                )
            )
        )
    )
);
```