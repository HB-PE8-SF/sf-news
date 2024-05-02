<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $students = ['Amélie', 'Alex'];

        return $this->render('index/index.html.twig', [
            'students' => $students,
            'welcome_text' => 'Bonjour Monsieur !',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }

    #[Route('/articles', name: 'app_articles')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        return $this->render('index/articles.html.twig', [
            'articles' => $articleRepository->findAll()
        ]);
    }
}
