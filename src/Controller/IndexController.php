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
        $students = ['Amélie', 'Alex'];

        $studentObjects = [
            new Student('Amélie', 456123),
            new Student('Alex', 654987),
            new Student('Arnaud', 654123)
        ];

        return $this->render('index/index.html.twig', [
            'students' => $students,
            'studentsObj' => $studentObjects,
            'welcome_text' => 'Bonjour Monsieur !',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('index/about.html.twig');
    }
}
