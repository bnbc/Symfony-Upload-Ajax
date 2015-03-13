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
            // Chemins d'upload
            $web_dir = $this->get('kernel')->getRootDir() . '/../web/';
            $upload_dir = $web_dir . $this->container->getParameter('bnbc_upload.upload_folder') . '/';
            $upload_url = str_replace($web_dir, $this->get('request')->getBasePath(), $upload_dir);
            
            $upload_handler = new \Bnbc\UploadBundle\BlueImp\UploadHandler(array(
                'upload_dir' => $upload_dir,
                'upload_url' => $upload_url,
                'param_name' => 'bnbc_ajax_file_form',
            ));
            exit(0);
        }
        else {
            return array();
        }
    }

}
