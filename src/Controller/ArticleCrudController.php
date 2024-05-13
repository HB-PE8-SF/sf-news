<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleImage;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/article/crud')]
class ArticleCrudController extends AbstractController
{
    #[Route('/', name: 'app_article_crud_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article_crud/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_crud_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $coverImage */
            $coverImage = $form->get('coverFile')->getData();
            $images = $form->get('article_images')->getData();

            if (!empty($images)) {
                foreach ($images as $image) {
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                    $safeFilename = $slugger->slug($originalFilename);
                    $filename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                    try {
                        $image->move(
                            'uploads/articles',
                            $filename
                        );
                        $imageObject = new ArticleImage();
                        $imageObject
                            ->setArticle($article)
                            ->setFilename($filename);

                        $entityManager->persist($imageObject);
                    } catch (FileException $e) {
                        $form->addError(new FormError("Erreur lors de l'upload"));
                    }
                }
            }

            if ($coverImage) {
                $originalFilename = pathinfo($coverImage->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $filename = $safeFilename . '-' . uniqid() . '.' . $coverImage->guessExtension();

                try {
                    $coverImage->move(
                        'uploads/articles',
                        $filename
                    );
                    $article
                        ->setCover($filename)
                        ->setCreatedAt(new DateTime());
                    $entityManager->persist($article);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_article_crud_index', [], Response::HTTP_SEE_OTHER);
                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }
            }
        }

        return $this->render('article_crud/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_crud_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article_crud/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_crud_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Article $article,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article_crud/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
