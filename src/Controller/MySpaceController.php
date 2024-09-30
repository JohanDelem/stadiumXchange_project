<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MySpaceController extends AbstractController
{
    #[Route('/my_space', name: 'mySpace')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $myTickets = $ticketRepository->findBy(['owner' => $user]);
        $myTicketsForSale = $ticketRepository->findBy([
            'userIdSeller' => $user,
            'state' => 'en vente'
        ]);
        $mySoldTickets = $ticketRepository->findBy([
            'userIdSeller' => $user,
            'state' => 'vendu'
        ]);

        return $this->render('my_space/index.html.twig', [
            'myTickets' => $myTickets,
            'myTicketsForSale' => $myTicketsForSale,
            'mySoldTickets' => $mySoldTickets,
        ]);
    }
}