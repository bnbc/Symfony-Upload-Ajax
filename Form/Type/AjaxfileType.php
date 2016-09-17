<?php

namespace Bnbc\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Options;

class AjaxfileType extends AbstractType
{

    public function __construct()
    {

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'formData'     => array(
                'max_file_size'     => null,
                'accept_file_types' => null,
                'upload_folder'     => null,
                'image_versions'    => null,
            ),
            'progressBar'         => false,
            'progressBarPosition' => 'append',
            'progressElement'     => null,
            'progressText'        => null,
            'required'            => false,
            'multiple'            => false,
            'dropZone'            => true,
            'autoUpload'          => true,
            'dropZoneText'        => 'Glisser/déposer les fichiers ici',
            'callbackFunction'    => null,
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'formData'            => $options['formData'],
            'progressBar'         => $options['progressBar'],
            'progressBarPosition' => $options['progressBarPosition'],
            'progressElement'     => $options['progressElement'],
            'progressText'        => $options['progressText'],
            'required'            => $options['required'],
            'multiple'            => $options['multiple'],
            'dropZone'            => $options['dropZone'],
            'autoUpload'          => $options['autoUpload'],
            'dropZoneText'        => $options['dropZoneText'],
            'callbackFunction'    => $options['callbackFunction'],
        ));
    }


    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'bnbc_ajax_file';
    }
}