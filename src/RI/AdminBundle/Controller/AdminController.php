<?php

namespace RI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RIAdminBundle:Admin:index.html.twig', array('name' => $name));
    }
}
