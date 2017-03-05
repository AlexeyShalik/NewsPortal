<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\EditUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/users")
 */
class UserAdminController extends Controller
{
    /**
     * @Route("/showProfiles", name="admin_show_profiles")
     */
    public function showProfilesAction(Request $request)
    {
        $listUsers= $this->get('dql_for_entities')->getDqlForUsers();

        $users = $this->get('knp_paginator_for_stage')->knpPaginatorForAdminPage($listUsers, $request);

        return $this->render('user/content-profiles.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/{id}/edit", name="admin_users_edit")
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_show_profiles');
        }

        return $this->render('user/edit-profile-user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remote", name="admin_users_remove")
     */
    public function remoteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_show_profiles');
    }
}
