<?php

namespace Bnbc\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

            $upload_handler = new \Bnbc\UploadBundle\BlueImp\UploadHandler($options);
            exit(0);
        }
        else {
            return array();
        }
    }

}
