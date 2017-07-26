# Bundle d'upload pour Symfony 2 et 3
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
Si cela n'a pas déjà été fais par composer, copiez les assets situés dans le dossier `/vendor/bnbc/upload-bundle/Bnbc/UploadBundle/Resources/public/js` dans le dossier `/web/bundles/bnbcupload/js` et ajoutez les fichiers javascripts à votre template, supprimez la ligne avec jQuery si vous l'avez déjà (requiert jQuery 1.6+).

```twig
<script src="{{ asset('bundles/bnbcupload/js/1_jquery.min.js') }}"></script>
<script src="{{ asset('bundles/bnbcupload/js/2_jquery.ui.widget.js') }}"></script>
<script src="{{ asset('bundles/bnbcupload/js/3_jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('bundles/bnbcupload/js/4_jquery.fileupload.js') }}"></script>
<script src="{{ asset('bundles/bnbcupload/js/5_init.js') }}"></script>
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
    form_themes:
            - BnbcUploadBundle:Form:fields.html.twig
```

## Options de configuration globale (facultatives)

### uniqid
Conversion de tous les noms de fichiers en uniqid  
Défaut : `false`

### max\_file\_size
Taille de fichier max en octets  
Défaut : `null` (la limite dépendra alors des variables `upload_max_filesize` et `post_max_size` de votre php.ini)  
Exemple : 10 * 1024 * 1024 = 10485760 représente (10 Mo)   

### accept\_file\_types
Expression régulière pour gérer les fichiers ou types de fichiers acceptés   
Défaut : `'/.+$/i'` (Autorise tous les fichiers)   
Exemple : `'/\.(gif|jpe?g|png)$/i'` (Autorise uniquement les fichiers images gif, jpeg et png)

### upload\_folder
Dossier de téléversement des fichiers par rapport à la racine du dossier web   
Défaut : `'uploads'`   
Exemple : `'uploads/test'` (Il est possible d'indiquer des sous-dossiers, ils se créeront automatiquement)

### image\_versions
Génération de formats supplémentaires, 3 formats possibles: `thumbnail`, `medium`, `large`. Le paramètre `crop` permet de recadrer l'image à la taille indiquée   
Défaut : `null`   
Exemple :
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
    uniqid: true
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
# Symfony 2
$formBuilder->add('myfield', 'bnbc_ajax_file');

# Symfony 3
$formBuilder->add('myfield', AjaxfileType::class);
```

## Options de configuration du champs fichier (facultatives)

### required
Champs requis ou non   
Défaut :  `false`

### progressBar
Affichage d'une barre de progression (calque qui voit sa largeur passer de 0 à 100%)   
Défaut :  `false`

### progressBarPosition
Position de la barre de progression, toutes les fonctions d'insertion jQuery sont autorisées   
Défaut :  `append`

### progressElement
Nom de l'élément auquel on assigne un attribut de progression qui va de 0 à 100 : data-progress   
Défaut :  `null`

### progressText
Nom de l'élément dans lequel le pourcentage de progression va être mis en texte   
Défaut :  `null`

### multiple
Téléversement de plusieurs fichiers en même temps   
Défaut :  `false`

### autoUpload
Le(s) fichier(s) se téléverse(nt) automatiquement après avoir été ajouté, si `false` un bouton de soumission apparait.   
Défaut :  `true`

### dropZone
Affichage d'une zone de glisser/déposer   
Défaut :  `true`

### dropZoneText
Texte la zone de glisser/déposer   
Défaut :  `'Drop file(s) here'`

### callbackFunction
Nom d'une fonction javascript à appeler une fois le téléversement terminé   
Défaut :  `null`   
Exemple : `afterUpload`   
Utilisation dans un template : `var afterUpload = function(files){};` où `files` est un tableau des fichiers téléversés

### formData
Vous pouvez redéfinir les options de configuration globale pour chaque champs dans le paramètre formData   
Défaut : ne pas mettre le paramètre

```php
# Symfony 2
$formBuilder->add('myfield', 'bnbc_ajax_file',
    array(
        'multiple'          => false,
        'autoUpload'        => true,
        'dropZone'          => true,
        'dropZoneText'      => 'Drop file(s) here',
        'callbackFunction'  => null,
        'formData'          => array(
            'uniqid'            => false,
            'max_file_size'     => 5 * 1024 * 1024,
            'accept_file_types' => null,
            'upload_folder'     => 'test',
            'image_versions'    => array(
                'thumbnail' => array(
                    'max_width'  => 100,
                    'max_height' => 100,
                    'crop'       => true
                )
            )
        )
    )
);

# Symfony 3
$formBuilder->add('myfield', AjaxfileType::class,
    array(
        'multiple'          => false,
        'autoUpload'        => true,
        'dropZone'          => true,
        'dropZoneText'      => 'Drop file(s) here',
        'callbackFunction'  => null,
        'formData'          => array(
            'uniqid'            => false,
            'max_file_size'     => 5 * 1024 * 1024,
            'accept_file_types' => null,
            'upload_folder'     => 'test',
            'image_versions'    => array(
                'thumbnail' => array(
                    'max_width'  => 100,
                    'max_height' => 100,
                    'crop'       => true
                )
            )
        )
    )
);
```

## Exemple de traitement du fichier téléversé (pas optimisé et pas forcément adapté à tous)   
```php

    /**
     * Creates a new entity.
     *
     * @Route("/new", name="admin_entity_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = new Entity();
        $form = $this->createForm('AdminBundle\Form\EntityType', $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush($entity);

            if($entity->getPhoto()){
                $entity->setPhoto($this->_movePhoto($entity));
            }            
            $em->flush($entity);

            return $this->redirectToRoute('admin_entity_show', array('id' => $entity->getId()));
        }

        return $this->render('AppBundle:entity:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    # Traitement de la photo
    protected function _movePhoto($data){
        $fs = new Filesystem();

        $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
        $coach_dir = $this->_createEntityFolder($data);

        # On déplace la photo dans le dossier
        if($photo = $data->getPhoto()){
            $ext = pathinfo($photo, PATHINFO_EXTENSION);
            $name = 'photo.' . $ext;

            # Si le fichier existe (il peut ne pas exister dans le cas d'une modification où on uploaderai pas un nouveau fichier)
            if(file_exists($dir . $photo)){
                $fs->copy($dir . $photo, $coach_dir . '/' . $name, true);
                $fs->remove($dir . $photo);
            }
            return $name;
        }
        else {
            return null;
        }
    }
    
    # Création du dossier pour accueillir l'image
    protected function _createEntityFolder($data){
        $fs = new Filesystem();
        $dir = $this->get('kernel')->getRootDir() . '/../web/data/entity/' . $data->getId();
        try {
            $fs->mkdir($dir);
        }
        catch (IOExceptionInterface $e) {
            echo "Une erreur est survenue lors de la création du dossier : ". $e->getPath();
        }
        return $dir;
    }

```