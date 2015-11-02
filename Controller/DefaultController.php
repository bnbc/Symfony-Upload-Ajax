<?php

namespace Bnbc\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->get('request');
        if($request->isXmlHttpRequest()){

            # upload_folder
            $web_dir = $this->get('kernel')->getRootDir() . '/../web/';
            $upload_dir = $web_dir . $this->container->getParameter('bnbc_upload.upload_folder') . '/';

            if(null !== $request->get('upload_folder'))
                $upload_dir = $web_dir . $request->get('upload_folder') . '/';

            # Création du dossier
            $fs = new Filesystem();
            try {
                $fs->mkdir($upload_dir);
            }
            catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at : ". $e->getPath();
            }

            # accept_file_types
            $accept_file_types = $this->container->getParameter('bnbc_upload.accept_file_types');
            if(null !== $request->get('accept_file_types'))
                $accept_file_types = $request->get('accept_file_types');

            # max_file_size
            $max_file_size = $this->container->getParameter('bnbc_upload.max_file_size');
            if(null !== $request->get('max_file_size'))
                $max_file_size = $request->get('max_file_size');

            # image_versions
            $image_versions = $this->container->getParameter('bnbc_upload.image_versions');
            if(null !== $request->get('image_versions'))
                $image_versions = $request->get('image_versions');

            $image_versions[''] = array(
                'auto_orient' => true
            );

            $upload_url = str_replace($web_dir, $request->getBasePath(), $upload_dir);
            $options = array(
                'upload_dir'        => $upload_dir,
                'upload_url'        => $upload_url,
                'param_name'        => 'bnbc_ajax_file_form',
                'accept_file_types' => $accept_file_types,
                'max_file_size'     => $max_file_size,
                'image_versions'    => $image_versions,
            );

            $error_messages = array(
                1 => $this->get('translator')->trans('The uploaded file exceeds the upload_max_filesize directive in php.ini'),
                2 => $this->get('translator')->trans('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'),
                3 => $this->get('translator')->trans('The uploaded file was only partially uploaded'),
                4 => $this->get('translator')->trans('No file was uploaded'),
                6 => $this->get('translator')->trans('Missing a temporary folder'),
                7 => $this->get('translator')->trans('Failed to write file to disk'),
                8 => $this->get('translator')->trans('A PHP extension stopped the file upload'),
                'post_max_size' => $this->get('translator')->trans('The uploaded file exceeds the post_max_size directive in php.ini'),
                'max_file_size' => $this->get('translator')->trans('File is too big'),
                'min_file_size' => $this->get('translator')->trans('File is too small'),
                'accept_file_types' => $this->get('translator')->trans('Filetype not allowed'),
                'max_number_of_files' => $this->get('translator')->trans('Maximum number of files exceeded'),
                'max_width' => $this->get('translator')->trans('Image exceeds maximum width'),
                'min_width' => $this->get('translator')->trans('Image requires a minimum width'),
                'max_height' => $this->get('translator')->trans('Image exceeds maximum height'),
                'min_height' => $this->get('translator')->trans('Image requires a minimum height'),
                'abort' => $this->get('translator')->trans('File upload aborted'),
                'image_resize' => $this->get('translator')->trans('Failed to resize image')
            );

            $upload_handler = new \Bnbc\UploadBundle\BlueImp\UploadHandler($options, true, $error_messages);
            exit(0);
        }
        else {
            return array();
        }
    }

}
