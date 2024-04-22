<?php

namespace App\Controller;

use App\Entity\Category;
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
    public function item(Category $category): Response
    {
        return $this->render('categories/item.html.twig', [
            'category' => $category
        ]);
    }
}
