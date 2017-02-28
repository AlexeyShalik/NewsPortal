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
            ->findByMailingOfLetters(true);

        $count = 0;

        foreach ($users as $user) {
            $count += 1;
            $message = \Swift_Message::newInstance()
                ->setSubject('NewsPortal')
                ->setFrom($this->getContainer()->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody($this->getContainer()->get('templating')->render('cron-email.html.twig'));

            $this->getContainer()->get('mailer')->send($message);

            if ($count > 100) {
                gc_collect_cycles();
                $count = 0;
            }
        }
        $output->writeln('Message sent successfully!');
    }
}
