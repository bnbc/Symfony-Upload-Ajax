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
            ),
            'multiple'      => false,
            'dropZone'      => true,
            'autoUpload'    => true,
            'dropzoneText' => 'Drop file(s) here',
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'formData'     =>  $options['formData'],
            'multiple'      => $options['multiple'], 
            'dropZone'      => $options['dropZone'],
            'autoUpload'    => $options['autoUpload'], 
            'dropzoneText' => $options['dropzoneText'], 
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