<?php

namespace App\Service;

use App\Entity\Member;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailSender
{
    const NEW_ACCOUNT_TITLE = 'CONFIRMATION DE VOTRE COMPTE SNOWTRICKS';

    const NEW_PASSWORD_TITLE = 'RÉINITIALISATION DE VOTRE MOT PASSE SNOWTRICKS';

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
     * @param Member $member
     * @param string $mailSubject
     * @param string $mailTemplate
     */
    public function sendMail(string $memberEmail, Member $member, string $mailSubject, string $mailTemplate): void
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
