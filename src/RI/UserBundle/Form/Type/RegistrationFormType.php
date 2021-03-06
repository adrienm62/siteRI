<?php

namespace RI\UserBundle\Form\Type;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('nom');
        $builder->add('prenom');
        $builder->add('adresse');
        $builder->add('codepostal');
        $builder->add('ville');
        $builder->add('ine');
        
    }
    
    public function getName() {
        return  'ri_user_register';
    }
}

?>
