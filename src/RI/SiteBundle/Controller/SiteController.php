<?php
namespace RI\SiteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use RI\SiteBundle\Entity\Partenaire;
    
    
class SiteController extends Controller {
    public function indexAction(){
        return $this->render('RISiteBundle:Site:index.html.twig');
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ajoutPartenaireAction() {
        $partenaire = new Partenaire();
        $formBuilder = $this->createFormBuilder($partenaire);
        
        $formBuilder
            ->add('par_nom', 'text')
            ->add('par_pays', 'text')
            ->add('par_ville', 'text')
            ->add('par_adresse', 'text')
            ->add('par_coordonnees', 'text');
        
        $form = $formBuilder->getForm();
         
    }
    
    
    public function suppressionPartenaireAction(){
        
    }
    
    
    
    
}


?>