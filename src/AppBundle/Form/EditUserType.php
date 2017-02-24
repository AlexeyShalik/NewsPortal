<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('attr' => array( 'class' => 'form-control', 'placeholder' => "email")))
            ->add('username', TextType::class, array('attr' => array( 'class' => 'form-control', 'placeholder' => "name" )))
            ->add('isActive', ChoiceType::class, [
                'expanded' => true,
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
            ])
            ->add('mailingOfLetters', CheckboxType::class, array('attr' => array( 'class' => 'mailing')))
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Moderator' => 'ROLE_MODERATOR',
                    'User' => 'ROLE_USER',
                    'Guest' => 'ROLE_GUEST',
                ], 'attr' => array( 'class' => 'selectpicker', 'multiple data-max-options' => "2" ),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}
