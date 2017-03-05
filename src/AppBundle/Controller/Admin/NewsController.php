<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Article;
use AppBundle\Form\EditArticlesType;
use AppBundle\Form\LoadImagesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/moderator")
 */
class NewsController extends Controller
{
    /**
     * @Route("/showArticles", name="moderator_show_articles")
     */
    public function showArticlesAction(Request $request)
    {
        $listArticles = $this->get('dql_for_entities')->getDqlForArticles();

        $articles = $this->get('knp_paginator_for_stage')->knpPaginatorForAdminPage($listArticles, $request);

        return $this->render('articles/content-articles.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * @Route("/{id}/edit", name="moderator_articles_edit")
     */
    public function editAction(Request $request, Article $article)
    {
        $form = $this->createForm(EditArticlesType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('moderator_show_articles');
        }

        return $this->render('articles/articles-edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove", name="moderator_articles_remove")
     */
    public function remoteAction(Request $request, Article $article, $id)
    {
        if (file_exists("D:/PHP/Projects/CourseWork/NewsPortal/web/img/newsImage/mini/$id.jpg")) {
            unlink("D:/PHP/Projects/CourseWork/NewsPortal/web/img/newsImage/mini/$id.jpg");
        }
        if (file_exists("D:/PHP/Projects/CourseWork/NewsPortal/web/img/newsImage/$id.jpg")) {
            unlink("D:/PHP/Projects/CourseWork/NewsPortal/web/img/newsImage/$id.jpg");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('moderator_show_articles');
    }

    /**
     * @Route("/add", name="moderator_articles_add")
     */
    public function addArticleAction(Request $request)
    {
        $form = $this->createForm(EditArticlesType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            if ($request->files->get('photo')!=null) {
                $id = $this->getDoctrine()->getRepository('AppBundle\Entity\Article')->findBy(array('news' => $article->getNews()));

                $image = $request->files->get('photo');
                $image->move($this->getParameter('brochures_directory'), $id[0]->getId() . '.jpg');
            }
            return $this->redirectToRoute('moderator_show_articles');
        }

        return $this->render('articles/articles-add.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}
