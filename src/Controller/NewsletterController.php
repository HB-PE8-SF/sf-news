<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'app_newsletter_subscribe')]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletterEmail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletterEmail);
            $em->flush();

            $this->addFlash('success', 'Merci, votre email a bien été enregistré');
            return $this->redirectToRoute('app_homepage');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', "Une erreur est survenue pendant le traitement du formulaire, en plus Nabil m'oblige à écrire ce message, merci de consulter ci-dessous le détail des erreurs, bien qu'elles soient décrites en détail auprès des champs de formulaire concernés");
        }

        return $this->render('newsletter/subscribe.html.twig', [
            'newsletterForm' => $form,
        ]);
    }

    #[Route('/newsletter/confirm', name: 'app_newsletter_confirm')]
    public function confirm(): Response
    {
        return $this->render('newsletter/confirm.html.twig');
    }
}
