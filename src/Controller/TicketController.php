<?php

namespace App\Controller;


use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;

use App\Entity\Selling;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/ticket')]
final class TicketController extends AbstractController{
    #[Route(name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // Récupérer l'id l'utilisateur connecté
            $user = $this->getUser();
            // Vérifier si un utilisateur est connecté (déjà le cas normalement!!)
            if (!$user) {
                throw new AccessDeniedException('Vous devez être connecté pour ajouter des détails de carte.');
            }

             // Attribuer l'utilisateur connecté au Ticket
            $ticket->setOwner($user);
            $ticket->setState('en vente');

            $entityManager->persist($ticket);
            $entityManager->flush();

            // rediriger vers la page d'accueil
            return $this->redirectToRoute('app_home_page', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($ticket->getState() === null) {
                $ticket->setState('en vente');
            }

            $entityManager->flush();

            return $this->redirectToRoute('mySpace', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {

            $entityManager->remove($ticket);
            $entityManager->flush();

           
        }

        return $this->redirectToRoute('mySpace', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/ticket/{id}/buy', name: 'app_ticket_buy', methods: ['GET', 'POST'])]
    public function buyTicket(Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour acheter un ticket.');
        }
    
        // Récupérer la première carte bancaire de l'utilisateur
        $cardDetails = $user->getCardDetails();
        if ($cardDetails->isEmpty()) {
            // Générer l'URL vers la page "Mon compte"
            $url = $this->generateUrl('mySpace');
        
            // Utiliser un flash message pour informer l'utilisateur, avec le lien généré
            $this->addFlash('error', 
                'Vous devez enregistrer une carte bancaire pour acheter un ticket. 
                Ajoutez une carte dans <a href="' . $url . '" class="flash-link">Mon compte</a>'
            );
        
            // Retourne la même page, ici avec un message flash
            return $this->render('ticket/show.html.twig', [
                'ticket' => $ticket, // Renvoie le ticket pour le template
            ]);
        }
        
    
        $firstCard = $cardDetails->first();
    
        // Créer une nouvelle instance de Selling
        $selling = new Selling();
    
        // Configurer la vente
        $selling->setTicket($ticket);
        $selling->setDate(new \DateTime());
        $selling->setPurchaser($user);
        $selling->setSeller($ticket->getOwner());
        $selling->setCardDetail($firstCard); // Utiliser l'objet CardDetails directement
    
        // Mettre à jour le propriétaire du ticket
        $ticket->setOwner($user);

         // Changer le statut du ticket
         $ticket->setState("vendu");
    
        // Persister les changements
        $entityManager->persist($selling);
        $entityManager->persist($ticket);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_home_page');
    }
}
