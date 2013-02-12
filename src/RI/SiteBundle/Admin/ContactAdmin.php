<?php

namespace RI\SiteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ContactAdmin extends Admin {
     protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'cont_nom');
    
     protected function configureFormFields(FormMapper $formMapper)
     {
         $formMapper->add('cont_nom')
                  ->add('cont_prenom')
                 ->add('partenaire')
                 ->add('cont_adresse')
                 ->add('cont_mail')
                 ->add('cont_tel');
                 
     }
     protected function configureDatagridFilters(DatagridMapper $datagridMapper)
     {
          $datagridMapper->add('cont_nom')
                  ->add('cont_prenom')
                 ->add('partenaire')
                 ->add('cont_adresse')
                 ->add('cont_mail')
                 ->add('cont_tel');
                 
     }
     
     protected function configureListFields(ListMapper $listMapper)
     {
         $listMapper->add('cont_nom')
                  ->add('cont_prenom')
                 ->add('partenaire')
                 ->add('cont_adresse')
                 ->add('cont_mail')
                 ->add('cont_tel');
     } 
}

?>
