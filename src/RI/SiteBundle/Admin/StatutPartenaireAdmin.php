<?php
namespace RI\SiteBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class StatutPartenaireAdmin extends Admin {
    protected $datagridValues = array('_sort_order' => 'ASC',
        '_sort_by' => 'stp_libelle');
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('stp_libelle');
          
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('stp_libelle');
    }
    
     protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('stp_libelle');
    }
}

?>
