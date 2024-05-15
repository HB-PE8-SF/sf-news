<?php

namespace App\EventSubscriber;

use App\Event\NewsletterRegisteredEvent;
use App\Mail\NewsletterService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Notifier\Bridge\Discord\DiscordOptions;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordEmbed;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFieldEmbedObject;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordFooterEmbedObject;
use Symfony\Component\Notifier\Bridge\Discord\Embeds\DiscordMediaEmbedObject;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class NewsletterRegisteredSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private NewsletterService $newsletterService,
        private ChatterInterface $chatter
    ) {
    }

    public function sendConfirmationEmail(NewsletterRegisteredEvent $event): void
    {
        $email = $event->getEmail();
        $this->newsletterService->sendConfirmation($email);
    }

    public function sendDiscordNotification(NewsletterRegisteredEvent $event): void
    {
        $email = $event->getEmail();
        $chatMessage = new ChatMessage('');

        // Create Discord Embed
        $discordOptions = (new DiscordOptions())
            ->username('Human Botster')
            ->addEmbed(
                (new DiscordEmbed())
                ->color(2021216)
                ->title('Nouvel email dans la newsletter !')
                ->thumbnail((new DiscordMediaEmbedObject())
                ->url('https://ld-web.github.io/hb-sf-pe8-course/img/logo.png'))
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Track')
                    ->value('[Out of Mind](https://open.spotify.com/track/4tLh6ilwgHAWnkui4hAR3p)')
                    ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Email')
                    ->value($email->getEmail())
                    ->inline(true)
                )
                ->addField(
                    (new DiscordFieldEmbedObject())
                    ->name('Artist')
                    ->value('DIIV')
                    ->inline(true)
                )
                ->footer(
                    (new DiscordFooterEmbedObject())
                    ->text('Human Booster - 2023')
                    ->iconUrl('https://ld-web.github.io/hb-sf-pe7-course/img/logo.png')
                )
            )
        ;

        $chatMessage->options($discordOptions);

        $this->chatter->send($chatMessage);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewsletterRegisteredEvent::NAME => [
                ['sendConfirmationEmail', 10],
                ['sendDiscordNotification', 5]
            ],
        ];
    }
}
