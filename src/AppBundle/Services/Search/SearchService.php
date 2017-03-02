<?php

namespace AppBundle\Services\Search;

use Symfony\Component\HttpFoundation\Request;

class SearchService
{
    public function searchArticle(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
        SELECT articles
        FROM AppBundle:Article articles 
        WHERE articles.news LIKE :request;
        ')->setParameter('request', $request);

        $result = $query->getResult();

        return $result;
    }
}
