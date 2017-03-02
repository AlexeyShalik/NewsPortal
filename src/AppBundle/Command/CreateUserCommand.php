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
        $count = 0;
        while (true) {
            $query = $this->getContainer()->get('doctrine')->getManager()
                ->createQuery(
                    'SELECT users
                FROM AppBundle:User users
                WHERE users.mailingOfLetters = TRUE '
                )
                ->setFirstResult($count)
                ->setMaxResults(100);
            $users = $query->getResult();

            if (empty($users)) {
                break;
            }

            foreach ($users as $user) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('NewsPortal')
                    ->setFrom($this->getContainer()->getParameter('mailer_user'))
                    ->setTo($user->getEmail())
                    ->setCharset('UTF-8')
                    ->setContentType('text/html')
                    ->setBody($this->getContainer()->get('templating')->render('cron-email.html.twig'));

                $this->getContainer()->get('mailer')->send($message);
                $count += 1;
            }
            $this->getContainer()->get('doctrine')->getManager()->clear();
        }
        $output->writeln('Message sent successfully!');
    }
}
