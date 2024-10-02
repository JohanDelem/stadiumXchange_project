<?php

namespace App\Controller;

use App\Entity\CardDetails;
use App\Form\CardDetailsType;
use App\Repository\CardDetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/card/details')]
final class CardDetailsController extends AbstractController{
    #[Route(name: 'app_card_details_index', methods: ['GET'])]
    public function index(CardDetailsRepository $cardDetailsRepository): Response
    {
        return $this->render('card_details/index.html.twig', [
            'card_details' => $cardDetailsRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_card_details_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cardDetail = new CardDetails();
        $form = $this->createForm(CardDetailsType::class, $cardDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            
            // Vérifier si un utilisateur est connecté (déjà le cas normalement!!)
            if (!$user) {
                throw new AccessDeniedException('Vous devez être connecté pour ajouter des détails de carte.');
            }

            // Attribuer l'utilisateur connecté au cardDetail
            $cardDetail->setUser($user);

            $entityManager->persist($cardDetail);
            $entityManager->flush();

            // return $this->redirectToRoute('app_card_details_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('mySpace', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->render('card_details/new.html.twig', [
            'card_detail' => $cardDetail,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_card_details_show', methods: ['GET'])]
    public function show(CardDetails $cardDetail): Response
    {
        return $this->render('card_details/show.html.twig', [
            'card_detail' => $cardDetail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_card_details_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CardDetails $cardDetail, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CardDetailsType::class, $cardDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_card_details_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('card_details/edit.html.twig', [
            'card_detail' => $cardDetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete_card', methods: ['POST'])]
    public function delete(Request $request, CardDetails $cardDetail, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cardDetail->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cardDetail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mySpace', [], Response::HTTP_SEE_OTHER);
    }
}
