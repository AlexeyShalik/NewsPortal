<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="user_search")
     */
    public function searchAction(Request $request)
    {
        $articles = $this->get('search_article')->searchArticle($request);

        $paginator  = $this->get('knp_paginator');
        $content = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );

        return $this->render('search.html.twig', array(
            'content' => $content,
        ));
    }
}
