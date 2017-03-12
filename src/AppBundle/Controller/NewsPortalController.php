<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @ParamConverter("article", class="AppBundle:Article")
     */
    public function showArticleAction(Article $article)
    {
        $article->setPopular($article->getPopular() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $filename = $this->getParameter('image_large') . $article->getId() . ".jpg";
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
     * @ParamConverter("category", class="AppBundle:Category",  options={"mapping": {"category" : "name"}})
     */
    public function showArticlesCategoryAction(Request $request, $category)
    {
        $listArticles = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findByCategory(
                $category->getId());

        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForHomePage($listArticles, $request);

        return $this->render('content.html.twig', array('content' => $content));
    }
}
