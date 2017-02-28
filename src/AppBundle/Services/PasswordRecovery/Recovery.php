<?php

namespace AppBundle\Services\PasswordRecovery;

use AppBundle\Entity\PasswordRecovery;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class Recovery
{
    private $em;
    private $encoder;
    private $token;

    public function __construct(Container $container, EntityManager $em, UserPasswordEncoder $passwordEncoder)
    {
        $this->token = $this->generate();
        $this->em = $em;
        $this->container = $container;
        $this->encoder = $passwordEncoder;
    }

    public function recover(PasswordRecovery $recovery, $plainPassword)
    {
        $user = $recovery->getUser();
        if (!$plainPassword) {
            return;
        }
        $password = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->remove($recovery);
        $this->em->flush();
    }
    public function createNewRecovery(PasswordRecovery $recovery, User $user)
    {
        $recovery->setAccessToken($this->token);
        $recovery->setUser($user);
        $recovery->setExpires('1h');
        $this->em->persist($recovery);
        $this->em->flush();
    }

    public function getRecoveryEntity($token)
    {
        $recoveryEntity = null;
        if ($token) {
            $recoveryEntity = $this->em->getRepository('AppBundle:PasswordRecovery')->findOneBy(['accessToken' => $token]);
        }

        return $recoveryEntity;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function generate()
    {
        return md5(sha1(md5(time())));
    }
}
