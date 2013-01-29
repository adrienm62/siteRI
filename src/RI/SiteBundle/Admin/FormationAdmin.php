<?php
namespace RI\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
class FormationAdmin extends Admin {
    protected function configureFormFields(FormMapper $formMapper)
     {
         $formMapper
                  ->add('for_libelle')->add('departement')->add('for_annee');
                 
     }
     protected function configureDatagridFilters(DatagridMapper $datagridMapper)
     {
          $datagridMapper
                  ->add('for_libelle')->add('departement')->add('for_annee');
                 
     }
     
     protected function configureListFields(ListMapper $listMapper)
     {
         $listMapper
                  ->add('for_libelle')->add('departement')->add('for_annee');
                 
     } 
     
     
}

?>
