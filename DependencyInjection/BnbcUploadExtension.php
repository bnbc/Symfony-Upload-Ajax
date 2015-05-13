<?php

namespace Bnbc\UploadBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BnbcUploadExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        # On rajoute le tableau "image_versions" si non présent, car sinon ça provoque une erreur : "the parameter bnbc_upload.image_versions must be defined", pas trouvé de solution dans le Configuration.php...
        if(!isset($config['image_versions']))
            $config['image_versions'] = null;

        # On met la config du bundle dans la config globale accessible depuis n'importe où
        foreach($config as $key=>$value){
            $container->setParameter('bnbc_upload.' . $key, $value);
        }
    }
}
