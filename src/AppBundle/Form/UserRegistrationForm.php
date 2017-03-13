<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                TextType::class,
                array(
                    'attr' => array(
                        'class'=>'form-control',
                        'placeholder'=>'Name',
                        )
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'attr' => array(
                        ' class'=>'form-control',
                        'placeholder'=>'Email address',
                        )
                )
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'attr' => array(
                            'class'=>'form-control', 'placeholder'=>'Password',)),
                    'second_options' => array(
                        'attr' => array(
                            'class'=>'form-control',
                            'placeholder'=>'Repeat Password',)),
            ))
            ->add(
                'save',
                SubmitType::class,
                array(
                    'label' => 'sign up',
                    'attr' => array(
                        'class'=>'btn btn-lg btn-primary btn-block'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default', 'Registration'],
        ]);
    }
}
