<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailSender
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $memberEmail
     * @param $member
     * @param string $mailSubject
     * @param string $mailTemplate
     */
    public function sendMail(string $memberEmail, $member, string $mailSubject, string $mailTemplate)
    {
        $email = (new TemplatedEmail())
                ->from('noreply@snowtricks.com')
                ->to(new Address($memberEmail))
                ->subject($mailSubject)
                ->htmlTemplate($mailTemplate)
                ->context([
                    'member' => $member
                ])
                ;

        $this->mailer->send($email);

    }

}
