<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use App\Repository\SellingRepository;
use App\Repository\CardDetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MySpaceController extends AbstractController
{
    #[Route('/my_space', name: 'mySpace')]
    public function index(
        TicketRepository $ticketRepository, 
        SellingRepository $sellingRepository,
        CardDetailsRepository $cardDetailsRepository
    ): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $myTickets = $ticketRepository->findBy(['owner' => $user]);
        $myTicketsForSale = $ticketRepository->findBy([
            'owner' => $user,
            'state' => 'en vente'
        ]);
        $mySoldTickets = $sellingRepository->findBy([
            'seller' => $user,
        ]);

        // Récupérer les cartes bancaires de l'utilisateur
        $myCards = $cardDetailsRepository->findBy(['user' => $user->getId()]);

        return $this->render('my_space/index.html.twig', [
            'myTickets' => $myTickets,
            'myTicketsForSale' => $myTicketsForSale,
            'mySoldTickets' => $mySoldTickets,
            'myCards' => $myCards,
        ]);
    }
}