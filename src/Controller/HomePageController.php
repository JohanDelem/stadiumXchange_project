<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface; // Import du PaginatorInterface
use Symfony\Component\HttpFoundation\Request; // Import de la classe Request


class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(TicketRepository $ticketRepository,
     HttpClientInterface $httpClient,
     PaginatorInterface $paginator, // Ajout du paginator
     Request $request, // Ajout de la requête pour récupérer la page
      #[MapQueryParameter] ?string $query): Response
    {
        $tickets = $ticketRepository->findTicketsEnVente($query);


                // Pagination des résultats
                $ticketsPaginator = $paginator->paginate(
                    $tickets, // Requête pour récupérer les tickets
                    $request->query->getInt('page', 1), // Numéro de la page (par défaut, 1)
                    9 // Nombre de tickets par page
                );
          
        $allLogos = [];

        foreach ($tickets as $ticket) {
            $homeTeam = $ticket->getHomeTeam();
            $awayTeam = $ticket->getAwayTeam();

            // Récupération des logos avec un cache local pour éviter les appels répétitifs
            // Si l'équipe n'existe pas déjà en tant que clé dans mon tableau alors je fait la requete
            if (!array_key_exists($homeTeam, $allLogos)) {
                $allLogos[$homeTeam] = $this->getTeamLogo($homeTeam, $httpClient);
            }

            if (!array_key_exists($awayTeam,$allLogos)) {
                $allLogos[$awayTeam] = $this->getTeamLogo($awayTeam, $httpClient);
            }
        }

        return $this->render('home_page/index.html.twig', [
            'tickets' => $ticketsPaginator,
            'teamsLogo' => $allLogos,
        ]);
    }

    private function getTeamLogo(string $teamName, HttpClientInterface $httpClient): ?string
    {
        try {
            $response = $httpClient->request('GET',
                'https://apiv2.allsportsapi.com/football/?met=Teams&teamName=' . $teamName . '&APIkey=' . $this->getParameter('app.api_key')
            );
            $data = $response->toArray();

            return $data['result'][0]['team_logo'] ?? null;
        } catch (\Exception $e) {
            // Loggez l'erreur si nécessaire
            // $this->get('logger')->error('Erreur lors de la récupération du logo de l\'équipe ' . $teamName . ': ' . $e->getMessage());
            return null;
        }
    }
}



