<?php
namespace RI\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class StageAdmin extends Admin {
     protected function configureFormFields(FormMapper $formMapper)
     {
         $formMapper->add('sta_sujet')
                  ->add('formation')
                 ->add('contact')
                 ->add('sta_debut')
                 ->add('sta_fin');
                 
     }
     protected function configureDatagridFilters(DatagridMapper $datagridMapper)
     {
          $datagridMapper->add('sta_sujet')
                  ->add('formation')
                 ->add('contact')
                 ->add('sta_debut')
                 ->add('sta_fin');
     }
     
     protected function configureListFields(ListMapper $listMapper)
     {
         $listMapper->add('sta_sujet')
                  ->add('formation')
                 ->add('contact')
                 ->add('sta_debut')
                 ->add('sta_fin');
     } 
     
     
}

?>
