<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('/home/page', name: 'app_home_page')]
    public function index(): Response
    {
        // tableau temporaire de tickets
        $tickets = [
            [
                'home_team' => 'Paris Saint-Germain',
                'away_team' => 'Olympique Lyonnais',
                'date_time' => '2024-09-30 20:45',
                'price' => 150,
                'stadium' => 'Parc des Princes'
            ],
            [
                'home_team' => 'Manchester United',
                'away_team' => 'Chelsea',
                'date_time' => '2024-10-01 17:00',
                'price' => 200,
                'stadium' => 'Old Trafford'
            ],
            [
                'home_team' => 'Real Madrid',
                'away_team' => 'FC Barcelona',
                'date_time' => '2024-10-05 21:00',
                'price' => 300,
                'stadium' => 'Santiago Bernabeu'
            ],
            [
                'home_team' => 'Bayern Munich',
                'away_team' => 'Borussia Dortmund',
                'date_time' => '2024-10-07 19:30',
                'price' => 180,
                'stadium' => 'Allianz Arena'
            ],
            [
                'home_team' => 'Liverpool',
                'away_team' => 'Manchester City',
                'date_time' => '2024-10-12 16:00',
                'price' => 220,
                'stadium' => 'Anfield'
            ],
            [
                'home_team' => 'Juventus',
                'away_team' => 'AC Milan',
                'date_time' => '2024-10-15 20:45',
                'price' => 170,
                'stadium' => 'Allianz Stadium'
            ],
            [
                'home_team' => 'Arsenal',
                'away_team' => 'Tottenham Hotspur',
                'date_time' => '2024-10-20 14:30',
                'price' => 190,
                'stadium' => 'Emirates Stadium'
            ],
            [
                'home_team' => 'Atletico Madrid',
                'away_team' => 'Sevilla',
                'date_time' => '2024-10-23 21:00',
                'price' => 160,
                'stadium' => 'Wanda Metropolitano'
            ],
            [
                'home_team' => 'Inter Milan',
                'away_team' => 'AS Roma',
                'date_time' => '2024-10-27 18:00',
                'price' => 140,
                'stadium' => 'San Siro'
            ],
            [
                'home_team' => 'Borussia Monchengladbach',
                'away_team' => 'RB Leipzig',
                'date_time' => '2024-10-30 19:30',
                'price' => 130,
                'stadium' => 'Borussia-Park'
            ],
            [
                'home_team' => 'Ajax',
                'away_team' => 'PSV Eindhoven',
                'date_time' => '2024-11-03 14:30',
                'price' => 120,
                'stadium' => 'Johan Cruyff Arena'
            ],
            [
                'home_team' => 'Napoli',
                'away_team' => 'Lazio',
                'date_time' => '2024-11-06 20:45',
                'price' => 150,
                'stadium' => 'Diego Armando Maradona Stadium'
            ],
            [
                'home_team' => 'Marseille',
                'away_team' => 'Monaco',
                'date_time' => '2024-11-10 21:00',
                'price' => 140,
                'stadium' => 'Stade Velodrome'
            ],
            [
                'home_team' => 'Benfica',
                'away_team' => 'Porto',
                'date_time' => '2024-11-13 20:15',
                'price' => 110,
                'stadium' => 'Estadio da Luz'
            ],
            [
                'home_team' => 'Bayer Leverkusen',
                'away_team' => 'Eintracht Frankfurt',
                'date_time' => '2024-11-17 15:30',
                'price' => 100,
                'stadium' => 'BayArena'
            ],
            [
                'home_team' => 'Leicester City',
                'away_team' => 'West Ham United',
                'date_time' => '2024-11-20 20:00',
                'price' => 130,
                'stadium' => 'King Power Stadium'
            ],
            [
                'home_team' => 'Valencia',
                'away_team' => 'Real Sociedad',
                'date_time' => '2024-11-24 18:30',
                'price' => 90,
                'stadium' => 'Mestalla'
            ],
            [
                'home_team' => 'Fiorentina',
                'away_team' => 'Atalanta',
                'date_time' => '2024-11-27 20:45',
                'price' => 110,
                'stadium' => 'Stadio Artemio Franchi'
            ],
            [
                'home_team' => 'Lyon',
                'away_team' => 'Lille',
                'date_time' => '2024-12-01 21:00',
                'price' => 120,
                'stadium' => 'Groupama Stadium'
            ],
            [
                'home_team' => 'Sporting CP',
                'away_team' => 'Braga',
                'date_time' => '2024-12-04 20:15',
                'price' => 80,
                'stadium' => 'Estadio Jose Alvalade'
            ]
        ];

        // Envoie le tableau de tickets à la vue
        return $this->render('home_page/index.html.twig', [
            'tickets' => $tickets
        ]);
    }
}


/*
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}

*/






