<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use AppBundle\Repository\ArticleRepository;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('Home', array('childrenAttributes' => array('class' => 'nav nav-list')));

        $menu
            ->addChild(
                'Home Page',
                array(
                    'route' => 'portal'
                )
            );

        $childrenForCategories = $menu
            ->addChild(
                'Categories',
                array(
                    'route' => 'portal',
                    'childrenAttributes' => array(
                        'class' => 'nav nav-list',
                        'hidden' => 'true'
                    )
                )
            )
            ->setAttributes(
                array(
                    'id' => 'category',
                    'style' => "cursor:default"
                )
            );

        $categories = $this->container->get('doctrine')->getRepository('AppBundle:Category')
        ->findAll();

        foreach ($categories as $category) {
            $childrenForCategories
                ->addChild(
                    $category->getName(),
                    array(
                        'route' => 'homepage'
                    )
                );
        }

        return $menu;
    }

    public function modMenu(FactoryInterface $factory, array $options)
    {
        return $menu;
    }
}
