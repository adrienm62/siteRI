<?php

namespace RI\SecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SecBundle:Sec:index.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function voirDocumentSecAction(){
        return $this->render('RISiteBundle:Sec:documentSec.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function voirInscEtuAction(){
        return $this->render('RISiteBundle:Sec:InscEtu.html.twig');
    }
}
