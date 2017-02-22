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
        $childrenForCategories->addChild('Politics', array('uri' => 'homepage'));
        $childrenForCategories->addChild('Business', array('uri' => 'homepage'));
        $childrenForCategories->addChild('Sport', array('uri' => 'homepage'));
        $childrenForCategories->addChild('Music and life', array('uri' => 'homepage'));
        $childrenForCategories->addChild('Travel', array('uri' => 'homepage'));
        $childrenForCategories->addChild('Science', array('uri' => 'homepage'));


        return $menu;
    }

    public function modMenu(FactoryInterface $factory, array $options)
    {
        return $menu;
    }
}
