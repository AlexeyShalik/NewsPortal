<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('send:emails')
            ->setDescription('Sending e-mail messages on a schedule');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->getContainer()->get('doctrine')
            ->getRepository('AppBundle:User')
            ->findAll();
        foreach ($users as $user) {
            $message = \Swift_Message::newInstance()
                ->setSubject('NewsPortal')
                ->setFrom('newsportalnovostyashka@gmail.com')
                ->setTo($user->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->getContainer()->get('templating')->render('cron-email.html.twig'));

            $this->getContainer()->get('mailer')->send($message);
        }
        $output->writeln('Message sent successfully!');
    }
}
