<?php

namespace AppBundle\Services\PasswordRecovery;

use Symfony\Component\DependencyInjection\Container;

class SendEmail
{
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->templating = $this->container->get('templating');
    }

    public function sendEmail($email, $token)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Recovery Password at NewsPortal')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($email)
            ->setContentType('text/html')
            ->setBody(
                $this->templating->render(
                    'password-recovery-email.html.twig', [
                        'access_token' => $token,
                    ]
                )
            );

        $this->container->get('mailer')->send($message);
    }
}
