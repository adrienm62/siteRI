<?php

namespace RI\AdminBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('RIAdminBundle:Admin:index.html.twig');
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

    public function ajoutStatutPartenaireAction()
    {
        
    }
    
    public function ajoutPartenaireAction()
    {
        
    }
    
    public function ajoutContactAction()
    {
        
    }
    
    public function ajoutStageAction()
    {
        
    }

}
