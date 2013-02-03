<?php
namespace RI\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class PartenaireAdmin extends Admin {
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'par_nom');
    
     protected function configureFormFields(FormMapper $formMapper)
     {
         $formMapper->add('par_nom', 'text')
                  ->add('statutpartenaire')
                 ->add('par_pays', 'text')
                 ->add('par_ville', 'text')
                 ->add('par_adresse', 'text');
                 
     }
     protected function configureDatagridFilters(DatagridMapper $datagridMapper)
     {
          $datagridMapper->add('par_nom', 'text')
                 ->add('statutpartenaire') 
                 ->add('par_pays', 'text')
                 ->add('par_ville', 'text')
                 ->add('par_adresse', 'text');
     }
     
     protected function configureListFields(ListMapper $listMapper)
     {
         $listMapper->add('par_nom', 'text')
                 ->add('statutpartenaire') 
                 ->add('par_pays', 'text')
                 ->add('par_ville', 'text')
                 ->add('par_adresse', 'text');
     } 
     
     
}

?>
