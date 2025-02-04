<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $to, string $subject, string $message): void
    {
        $email = (new Email())
            ->from('jarkezukna@gufum.com')
            ->to($to)
            ->subject($subject)
            ->text($message)
            ->html('<p>'.nl2br($message).'</p>');

        $this->mailer->send($email);
    }
}
