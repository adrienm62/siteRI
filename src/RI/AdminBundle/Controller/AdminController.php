<?php

namespace RI\AdminBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RI\SiteBundle\Entity\StatutPartenaire;
use RI\SiteBundle\Entity\Partenaire;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RIAdminBundle:Admin:index.html.twig', array('name' => $name));
    }
    /**
     * @Secure(roles="ROLE_ADMIN")
     */
    public function ajoutStatutPartenaireAction()
    {
        $statutpartenaire = new StatutPartenaire();
        
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('libelle', 'text');
        
        $form = $formBuilder->getForm();
        
        return $this->render('RIAdminBundle:Admin:ajouter.html.twig', array('form' => $form->createView()));
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
