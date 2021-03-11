<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerTest extends TestCase
{

    public function testMailer()
    {
                    
        $mailer = $this->createMock(MailerInterface::class);

        $email = (new Email())
            ->from('noreply@test.com')
            ->to('test@test.com')
            ->subject('Test')
            ->text('Title Test')
            ->html('<p>Message Test</p>');

        $mailer->send($email);

        $this->addToAssertionCount(1);

    } 

}
