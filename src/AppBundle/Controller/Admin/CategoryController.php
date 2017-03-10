<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Form\EditCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/moderator")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/showCategory", name="moderator_show_category")
     */
    public function showCategoriesAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $content = $this->get('knp_paginator_for_stage')->knpPaginatorForCategory($categories, $request);
        return $this->render('category/content-category.html.twig', array('content' => $content));
    }

    /**
     * @Route("/category/{id}/edit", name="moderator_category_edit")
     */
    public function editAction(Request $request, Category $article)
    {
        $form = $this->createForm(EditCategoryType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('moderator_show_category');
        }

        return $this->render('category/category-edit.html.twig', [
            'categoryForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}/remove", name="moderator_category_remove")
     */
    public function remoteAction(Request $request, Category $category, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('moderator_show_category');
    }

    /**
     * @Route("/category/add", name="moderator_category_add")
     */
    public function addArticleAction(Request $request)
    {
        $form = $this->createForm(EditCategoryType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('moderator_show_category');
        }

        return $this->render('category/category-add.html.twig', [
            'categoryForm' => $form->createView(),
        ]);
    }
}
