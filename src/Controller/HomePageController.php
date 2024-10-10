<?php

namespace App\Controller;

use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends AbstractController
{
    private array $teamNamesMap = [
        'Albania' => 'Albanie',
        'Albanie' => 'Albania',
        'Andorra' => 'Andorre',
        'Armenia' => 'Arménie',
        'Austria' => 'Autriche',
        'Azerbaijan' => 'Azerbaïdjan',
        'Belarus' => 'Biélorussie',
        'Belgium' => 'Belgique',
        'Bosnia and Herzegovina' => 'Bosnie-Herzégovine',
        'Bulgaria' => 'Bulgarie',
        'Croatia' => 'Croatie',
        'Cyprus' => 'Chypre',
        'Czech Republic' => 'République tchèque',
        'Denmark' => 'Danemark',
        'England' => 'Angleterre',
        'Estonia' => 'Estonie',
        'Finland' => 'Finlande',
        'France' => 'France',
        'Georgia' => 'Géorgie',
        'Germany' => 'Allemagne',
        'Greece' => 'Grèce',
        'Hungary' => 'Hongrie',
        'Iceland' => 'Islande',
        'Ireland' => 'Irlande',
        'Italy' => 'Italie',
        'Kazakhstan' => 'Kazakhstan',
        'Latvia' => 'Lettonie',
        'Liechtenstein' => 'Liechtenstein',
        'Lithuania' => 'Lituanie',
        'Luxembourg' => 'Luxembourg',
        'Malta' => 'Malte',
        'Moldova' => 'Moldavie',
        'Montenegro' => 'Monténégro',
        'Netherlands' => 'Pays-Bas',
        'North Macedonia' => 'Macédoine du Nord',
        'Norway' => 'Norvège',
        'Poland' => 'Pologne',
        'Portugal' => 'Portugal',
        'Romania' => 'Roumanie',
        'Russia' => 'Russie',
        'San Marino' => 'Saint-Marin',
        'Scotland' => 'Écosse',
        'Serbia' => 'Serbie',
        'Slovakia' => 'Slovaquie',
        'Slovenia' => 'Slovénie',
        'Spain' => 'Espagne',
        'Sweden' => 'Suède',
        'Switzerland' => 'Suisse',
        'Ukraine' => 'Ukraine',
        'Wales' => 'Pays de Galles'
    ];

    #[Route('/', name: 'app_home_page')]
    public function index(
        TicketRepository $ticketRepository,
        HttpClientInterface $httpClient,
        PaginatorInterface $paginator,
        Request $request,
        #[MapQueryParameter] ?string $query
    ): Response {
        $tickets = $ticketRepository->findTicketsEnVente($query);

        $ticketsPaginator = $paginator->paginate(
            $tickets,
            $request->query->getInt('page', 1),
            9
        );

        $allLogos = [];

        foreach ($tickets as $ticket) {
            $homeTeam = $ticket->getHomeTeam();
            $awayTeam = $ticket->getAwayTeam();

            // Convertir les noms des équipes en anglais pour l'API
            $homeTeamEn = $this->mapToEnglish($homeTeam);
            $awayTeamEn = $this->mapToEnglish($awayTeam);

            // Obtenir les logos en anglais et mise ne cache local
            if (!array_key_exists($homeTeamEn, $allLogos)) {
                $allLogos[$homeTeamEn] = $this->getTeamLogo($homeTeamEn, $httpClient);
            }

            if (!array_key_exists($awayTeamEn, $allLogos)) {
                $allLogos[$awayTeamEn] = $this->getTeamLogo($awayTeamEn, $httpClient);
            }
        }

        // Mapper les logos pour l'affichage avec les noms en français
        $logosInFrench = [];
        foreach ($allLogos as $teamEn => $logo) {
            $teamFr = $this->mapToFrench($teamEn);  // Convertir en français pour l'affichage
            $logosInFrench[$teamFr] = $logo;
        }

        return $this->render('home_page/index.html.twig', [
            'tickets' => $ticketsPaginator,
            'teamsLogo' => $logosInFrench,  // Passer les logos avec les noms français
        ]);
    }

    private function mapToEnglish(string $teamName): string
    {
        return array_search($teamName, $this->teamNamesMap) ?: $teamName;
    }

    private function mapToFrench(string $teamName): string
    {
        return $this->teamNamesMap[$teamName] ?? $teamName;
    }

    private function getTeamLogo(string $teamName, HttpClientInterface $httpClient): ?string
    {
        try {
            $response = $httpClient->request('GET',
                'https://apiv2.allsportsapi.com/football/?met=Teams&teamName=' . urlencode($teamName) . '&APIkey=' . $this->getParameter('app.api_key')
            );
            $data = $response->toArray();

            return $data['result'][0]['team_logo'] ?? null;
        } catch (\Exception $e) {
            return null; 
        }
    }
}
