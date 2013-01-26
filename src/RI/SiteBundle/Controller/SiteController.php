<?php
namespace RI\SiteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use RI\SiteBundle\Entity\Partenaire;
use JMS\SecurityExtraBundle\Annotation\Secure;
    
    
class SiteController extends Controller {
    public function indexAction(){
        return $this->render('RISiteBundle:Site:index.html.twig');
    }
    
    
    
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirProfilAction(){
        return $this->render('RISiteBundle:Site:profil.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirPartenaireAction(){
        return $this->render('RISiteBundle:Site:partenaire.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function voirDocumentAction(){
        return $this->render('RISiteBundle:Site:document.html.twig');
    }
    
    
    
    
}


?>