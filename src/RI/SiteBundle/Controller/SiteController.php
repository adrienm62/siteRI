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
    
    public function voirPartenairesAction(){
        $partenaires = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Partenaire')->findAll();
 
        
        return $this->render('RISiteBundle:Site:listepartenaires.html.twig', array('partenaires' => $partenaires));
    }
    
}

?>