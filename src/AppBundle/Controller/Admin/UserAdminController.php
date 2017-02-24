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
     * @Route("/showProfiles", name="show_profiles")
     */
    public function indexAction()
    {
        $user=$this->getUser();

        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        return $this->render('user/profiles.html.twig', array(
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

            $this->addFlash('success', 'User updated.');

            return $this->redirectToRoute('show_profiles');
        }

        return $this->render('user/edit-profile-user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remote", name="admin_users_remote")
     */
    public function remoteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('show_profiles');
    }
}
