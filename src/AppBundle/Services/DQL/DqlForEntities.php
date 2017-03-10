<?php

namespace AppBundle\Services\DQL;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;

class DqlForEntities
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getDqlForArticles()
    {
        $em = $this->container->get('doctrine')->getManager()
            ->createQuery('SELECT news FROM AppBundle:Article news');

        $result = $em->getResult();

        return $result;
    }

    public function getDqlForUsers()
    {
        $em = $this->container->get('doctrine')->getManager()
            ->createQuery('SELECT users FROM AppBundle:User users');

        $result = $em->getResult();

        return $result;
    }

    public function getDqlForNewArticles()
    {
        $em = $this->container->get('doctrine')->getManager()
            ->createQuery(
                'SELECT news
                FROM AppBundle:Article news
                ORDER BY news.year DESC 
                ');

        $result = $em->getResult();

        return $result;
    }

    public function getDqlForPopularArticles()
    {
        $em = $this->container->get('doctrine')->getManager()
            ->createQuery(
                'SELECT news
                FROM AppBundle:Article news
                ORDER BY news.popular DESC 
                ');

        $result = $em->getResult();

        return $result;
    }

    public function getDqlForFilterArticles(Request $request)
    {
        $field = $request->query->get('sort');

        $em = $this->container->get('doctrine')->getManager()
            ->createQuery('
        SELECT articles
        FROM AppBundle:Article articles 
        WHERE articles.'.$field.' LIKE :request
        ')->setParameter('request', '%'.$request->query->get('filter').'%');

        $result = $em->getResult();

        return $result;
    }
}
