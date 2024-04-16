<?php

namespace App\Controller;

use App\Data\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        // Vrais noms récupérés d'une BDD
        $students = ['Amélie', 'Alex'];

        return $this->render('index/index.html.twig', [
            'students' => $students,
            'welcome_text' => 'Bonjour Monsieur !',
        ]);
    }
}
