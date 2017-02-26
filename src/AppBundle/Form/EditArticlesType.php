<?php


namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'news',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "name article"
                    )
                )
            )
            ->add(
                'category',
                EntityType::class,
                array(
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "name"
                    )
                )
            )
            ->add(
                'author',
                TextType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "author"
                    )
                )
            )
            ->add(
                'shortDescription',
                TextType::class,
                array(
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "short description"
                    )
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => "description"
                    )
                )
            )
            ->add(
                'year',
                DateType::class,
                    array(
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array(
                            'class' => 'form-control js-datepicker',
                            'placeholder' => "date")
                    )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
        ));
    }
}
