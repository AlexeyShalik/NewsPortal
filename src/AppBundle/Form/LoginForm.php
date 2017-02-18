<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username',null, array('attr' => array(
                ' class'=>'form-control', 'placeholder'=>'Email address',)))
            ->add('_password', PasswordType::class, array('attr' => array(
                ' class'=>'form-control', 'placeholder'=>'Password',)));
    }
}
