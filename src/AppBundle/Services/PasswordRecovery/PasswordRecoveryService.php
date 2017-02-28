<?php

namespace AppBundle\Services\PasswordRecovery;

use AppBundle\Entity\PasswordRecovery;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;

class PasswordRecoveryService
{
    private $container;
    private $formUtils;
    private $sendEmail;
    private $recovery;
    private $token;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->formUtils = $this->container->get('form_utils');
        $this->sendEmail = $this->container->get('email');
        $this->recovery = $this->container->get('recovery');
        $this->token = $this->recovery->getToken();
    }

    public function createNewRecovery(PasswordRecovery $recovery, User $user)
    {
        $this->recovery->createNewRecovery($recovery, $user);
        $this->sendEmail->sendEmail($user->getEmail(), $this->token);
    }

    public function validateEmail($email)
    {
        $constraint = new Email();
        $validator = $this->container->get('validator');

        return $validator->validate($email, $constraint);
    }

    public function getUserError(User $user)
    {
        $error = null;
        if (!($user instanceof User)) {
            $error = 'There is no user with such email';
        }

        return $error;
    }

    public function recover(PasswordRecovery $recovery, $plainPassword)
    {
        return $this->recovery->recover($recovery, $plainPassword);
    }
    public function getRecoveryEntity($token)
    {
        return $this->recovery->getRecoveryEntity($token);
    }

    public function getRecoveryForm(FormBuilder $builder)
    {
        return $this->formUtils->getRecoveryForm($builder);
    }

    public function getRecoveryConfirmationForm(FormBuilder $builder, $url)
    {
        return $this->formUtils->getRecoveryConfirmationForm($builder, $url);
    }
}
