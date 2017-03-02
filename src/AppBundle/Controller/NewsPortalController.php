<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsPortalController extends Controller
{
    /**
     * @Route("/portal", name="portal")
     */
    public function showAction(Request $request)
    {
        $dqlService = $this->get('dql_for_knp_paginator');
        $dql = $dqlService->getDqlForArticles();
        $em  = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $content = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('content.html.twig', array('content' => $content));
    }

    /**
     * @Route("/portal/article/{id}", name="portal_article_show")
     */
    public function showArticleAction($id)
    {
        $article = $this->getDoctrine()
           ->getRepository('AppBundle:Article')
           ->findOneById($id);

        $filename = "/img/newsImage/$id.jpg";
        $file_exists = file_exists($filename);

        return $this->render('article.html.twig', array(
            'article' => $article,
            'file_exists' => $file_exists,
        ));
    }
}
