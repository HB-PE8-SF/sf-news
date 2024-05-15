<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'articles' => $articleRepository->findRecent()
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }
}
