<?php

namespace RI\PartBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartController extends Controller
{
    public function indexAction()
    {
        return $this->render('RIPartBundle:Part:index.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_CONTACT")
     */
    public function voirStagiaireAction(){
        return $this->render('RIPartBundle:Part:stagiaires.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_CONTACT")
     */
    public function voirDocPartAction(){
            return $this->render('RIPartBundle:Part:documentPart.html.twig');
    }
}
