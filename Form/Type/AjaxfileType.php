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
            'compound'     => false,
            'max_size'     => null,
            'mime_types'   => null,
            'folder'       => null, 
            'multiple'     => false,
            'dropZone'     => true,
            'autoUpload'   => true,
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'max_size'     => $options['max_size'],
            'mime_types'   => $options['mime_types'],
            'folder'       => $options['folder'],
            'multiple'     => $options['multiple'], 
            'dropZone'     => $options['dropZone'],
            'autoUpload'   => $options['autoUpload'], 
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