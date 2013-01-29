<?php
namespace RI\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class DepartementAdmin extends Admin {
     protected function configureFormFields(FormMapper $formMapper)
     {
         $formMapper
                  ->add('dpt_libelle');
                 
     }
     protected function configureDatagridFilters(DatagridMapper $datagridMapper)
     {
          $datagridMapper->add('dpt_libelle');
     }
     
     protected function configureListFields(ListMapper $listMapper)
     {
         $listMapper->add('dpt_libelle');
     } 
}

?>
