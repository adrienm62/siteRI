<?php

namespace RI\EtuBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EtuController extends Controller
{
    public function indexAction()
    {
        return $this->render('EtuBundle:Etu:index.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirProfilAction(){
        return $this->render('RISiteBundle:Etu:profil.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirPartenaireAction(){
        return $this->render('RISiteBundle:Etu:partenaire.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirDocumentAction(){
        return $this->render('RISiteBundle:Etu:document.html.twig');
    }
}
