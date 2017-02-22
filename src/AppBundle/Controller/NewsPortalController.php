<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NewsPortalController extends Controller
{
    /**
     * @Route("/portal", name="portal")
     */
    public function showAction(Request $request)
    {
        $user = $this->getUser();

        $em  = $this->getDoctrine()->getEntityManager();
       // $newsPosts  = $em->getRepository('AppBundle:Article')->findAll();
        $dql = "SELECT news FROM AppBundle:Article news";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)
        );


        return $this->render('index.html.twig', array('user' => $user, 'result' => $result));
    }
}
