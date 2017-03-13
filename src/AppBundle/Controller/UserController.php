<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->sendEmailAction($user->getEmail(), $user);

            return $this->get('security.authentication.guard_handler')
              ->authenticateUserAndHandleSuccess(
               $user,
                  $request,
                    $this->get('app.security.login_form_authenticator'),
                   'main'
                );
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    public function sendEmailAction($email, $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Registration at NewsPortal')
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($email)
            ->setContentType('text/html')
            ->setBody(
                $this->renderView(
                    'registration-email.html.twig',
                    array('user' => $user->getUsername(), 'token' => $user->getId())
                )
            );

        $this->get('mailer')->send($message);
    }

    /**
     * @Route("/activate/{token}", name="user_is_active")
     * @ParamConverter("token", class="AppBundle:User")
     */
    public function activateAction($token)
    {
        $user = $token;
        $user->setIsActive(true);
        $user->setRoles('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->addFlash('success', 'Welcome '.$user->getUsername());

        return $this->render('active.html.twig');
    }
}
