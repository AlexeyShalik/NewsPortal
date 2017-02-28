<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('Home', array('childrenAttributes' => array('class' => 'nav nav-list')));

        $menu->addChild('Home Page', array(
        'route' => 'portal'));
        $childrenForCategories = $menu->addChild('Categories', array('route' => 'portal',
             'childrenAttributes' => array('class' => 'nav nav-list', 'hidden' => 'true')))
            ->setAttributes(array('id' => 'category', 'style' => "cursor:default"));
        $childrenForCategories->addChild('Politics', array('route' => 'homepage'));
        $childrenForCategories->addChild('Business', array('route' => 'homepage'));
        $childrenForCategories->addChild('Sport', array('route' => 'homepage'));
        $childrenForCategories->addChild('Music and life', array('route' => 'homepage'));
        $childrenForCategories->addChild('Travel', array('route' => 'homepage'));
        $childrenForCategories->addChild('Science', array('route' => 'homepage'));


        return $menu;
    }

    public function modMenu(FactoryInterface $factory, array $options)
    {
        return $menu;
    }
}
