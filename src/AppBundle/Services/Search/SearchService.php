<?php

namespace AppBundle\Services\Search;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;

class SearchService
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function searchArticle(Request $request)
    {
        $em = $this->container->get('doctrine')->getManager()
            ->createQuery('
        SELECT articles
        FROM AppBundle:Article articles 
        WHERE articles.news LIKE :request
        ')->setParameter('request', '%'.$request->query->get('search').'%');

        $result = $em->getResult();

        return $result;
    }
}
