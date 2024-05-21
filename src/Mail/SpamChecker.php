<?php

namespace App\Mail;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpamChecker
{
    public function __construct(
        private HttpClientInterface $spamChecker
    ) {
    }

    public function isSpam(string $email): bool
    {
        $response = $this->spamChecker->request(
            "POST",
            "/api/check",
            [
                'json' => [
                    'email' => $email
                ]
            ]
        );

        $value = $response->toArray();

        return $value['result'] === 'spam';
    }
}
