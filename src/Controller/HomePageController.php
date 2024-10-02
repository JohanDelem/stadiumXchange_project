<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;


class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(TicketRepository $ticketRepository, #[MapQueryParameter] ?string $query): Response
    {
         $tickets = $ticketRepository->findTicketsEnVente($query);
        // $tickets = $ticketRepository->findAll();
        return $this->render('home_page/index.html.twig', [
            'tickets' => $tickets
        ]);
    }
}






