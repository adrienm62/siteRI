<?php
namespace RI\SiteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;

    
    
class SiteController extends Controller {
    public function indexAction(){
        return $this->render('RISiteBundle:Site:index.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ajoutPartenaireAction() {
        
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function suppressionPartenaireAction(){
        
    }
    
    
    
    
}


?>