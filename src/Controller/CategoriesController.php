<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('categories/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categories/{id}', name: 'app_category_item')]
    // J'injecte le CategoryRepository (type-hint)
    // car c'est le service qui me permet de communiquer avec la base de données
    // à propos des catégories
    public function item(CategoryRepository $categoryRepository, int $id): Response
    {
        // Puis je demande à la BDD la catégorie qui a cet ID
        $category = $categoryRepository->find($id);

        if ($category === null) {
            throw new NotFoundHttpException('Catégorie non trouvée');
        }

        return $this->render('categories/item.html.twig', [
            'category' => $category
        ]);
    }
}
