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
    public function showAllArticlesAction(Request $request)
    {
        $listArticles = $this->get('dql_for_entities')->getDqlForArticles();

        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForHomePage($listArticles, $request);

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

        $article->setPopular($article->getPopular()+1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $filename = "D:/PHP/Projects/CourseWork/NewsPortal/web/img/newsImage/$id.jpg";
        $file_exists = file_exists($filename);

        return $this->render('article.html.twig', array(
            'article' => $article,
            'file_exists' => $file_exists,
        ));
    }

    /**
     * @Route("/portal/newArticles", name="portal_new_articles")
     */
    public function showNewArticlesAction(Request $request)
    {
        $listArticles = $this->get('dql_for_entities')->getDqlForNewArticles();

        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForHomePage($listArticles, $request);

        return $this->render('content.html.twig', array('content' => $content));
    }

    /**
     * @Route("/portal/popular", name="portal_popular_articles")
     */
    public function showPopularArticlesAction(Request $request)
    {
        $listArticles = $this->get('dql_for_entities')->getDqlForPopularArticles();

        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForHomePage($listArticles, $request);

        return $this->render('content.html.twig', array('content' => $content));
    }

    /**
     * @Route("/portal/{category}", name="portal_by_category")
     */
    public function showArticlesCategoryAction(Request $request, $category)
    {
        $listArticles = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findByCategory(
                $this->getDoctrine()
                    ->getRepository('AppBundle:Category')->findOneByName($category)->getId());

        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForHomePage($listArticles, $request);

        return $this->render('content.html.twig', array('content' => $content));
    }
}
