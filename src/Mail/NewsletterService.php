<?php

namespace App\Mail;

use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NewsletterService
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function sendConfirmation(NewsletterEmail $newsletterEmail): void
    {
        $email = (new Email())
            ->from('admin@hb-corp.com')
            ->to($newsletterEmail->getEmail())
            ->subject('HB Corp - Inscription à la newsletter')
            ->text('Votre inscription a bien été enregistrée')
            ->html('<p>Votre adresse ' . $newsletterEmail->getEmail() . ' a bien été enregistrée</p>');

        $this->mailer->send($email);
    }
}
