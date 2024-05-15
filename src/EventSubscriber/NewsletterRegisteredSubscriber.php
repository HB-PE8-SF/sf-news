<?php

namespace App\EventSubscriber;

use App\Event\NewsletterRegisteredEvent;
use App\Mail\NewsletterService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsletterRegisteredSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private NewsletterService $newsletterService
    ) {
    }

    public function sendConfirmationEmail(NewsletterRegisteredEvent $event): void
    {
        $email = $event->getEmail();
        $this->newsletterService->sendConfirmation($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewsletterRegisteredEvent::NAME => 'sendConfirmationEmail',
        ];
    }
}
