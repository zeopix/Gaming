<?php

namespace Core\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
            'label' => 'Apodo'
             ))
            ->add('email', 'email', array(
            'label' => 'Correo electrónico'
        ))
            ->add('plainPassword','repeated', array(
            'type' => 'password',
            'first_name' => 'Contraseña',
            'second_name' => 'Repita la contraseña'
        ));

    }

    public function getName()
    {
        return 'core_userbundle_usertype';
    }
    public function getDefaultOptions(array $options) {
        $options = parent::getDefaultOptions($options);

        $options['required']= false;
        $options['data_class'] = "Core\UserBundle\Entity\User";

        return $options;
    }
}