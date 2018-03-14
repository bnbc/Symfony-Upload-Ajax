<?php

namespace Bnbc\UploadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AjaxfileType
 *
 * @package Bnbc\UploadBundle\Form\Type
 */
class AjaxfileType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'formData'     => array(
                'uniqid'            => null,
                'max_file_size'     => null,
                'accept_file_types' => null,
                'upload_folder'     => null,
                'image_versions'    => null,
            ),
            'progressBar'         => false,
            'progressBarPosition' => 'append',
            'progressBarClass'    => 'bnbc-ajax-file-progress',
            'progressElement'     => null,
            'progressText'        => null,
            'required'            => false,
            'multiple'            => false,
            'label'               => null,
            'dropZone'            => true,
            'autoUpload'          => true,
            'dropZoneText'        => 'Glisser/déposer les fichiers ici',
            'callbackFunction'    => null,
        ));
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'formData'            => $options['formData'],
            'progressBar'         => $options['progressBar'],
            'progressBarPosition' => $options['progressBarPosition'],
            'progressBarClass'    => $options['progressBarClass'],
            'progressElement'     => $options['progressElement'],
            'progressText'        => $options['progressText'],
            'required'            => $options['required'],
            'multiple'            => $options['multiple'],
            'label'               => $options['label'],
            'dropZone'            => $options['dropZone'],
            'autoUpload'          => $options['autoUpload'],
            'dropZoneText'        => $options['dropZoneText'],
            'callbackFunction'    => $options['callbackFunction'],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bnbc_ajax_file';
    }
}