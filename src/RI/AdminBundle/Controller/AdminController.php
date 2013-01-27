<?php

namespace RI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RIAdminBundle:Admin:index.html.twig', array('name' => $name));
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function voirGestionPartAction(){
        return $this->render('RISiteBundle:Sec:gestionPart.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function voirStageEtuAction(){
        return $this->render('RISiteBundle:Sec:stageEtu.html.twig');
    }
}
