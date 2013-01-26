<?php

namespace RI\AdminBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RIAdminBundle:Admin:index.html.twig', array('name' => $name));
    }
    
    public function ajoutStatutPartenaireAction()
    {
        $
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
