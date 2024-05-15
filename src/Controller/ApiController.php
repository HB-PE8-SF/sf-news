<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: "api_")]
class ApiController extends AbstractController
{
    #[Route('/articles', name: 'articles')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        /** @var \App\Entity\ApiToken $user */
        $user = $this->getUser();

        return $this->json(
            [
                'user' => [
                    'name' => $user->getName()
                ],
                'articles' => $articleRepository->findAll()
            ],
            context: ['groups' => 'articles:read']
        );
    }
}
