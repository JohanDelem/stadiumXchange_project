<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $teams = [
            'PSG', 'Marseille', 'Lyon', 'Lille', 'Monaco', 'Rennes', 'Lens', 'Montpellier', 
            'Nice', 'Strasbourg', 'Nantes', 'Bordeaux', 'Saint-Étienne', 'Reims', 'Angers', 
            'Metz', 'Brest', 'Lorient', 'Troyes', 'Clermont'
        ];

        $stadiums = [
            'PSG' => ['Parc des Princes', 'Paris'],
            'Marseille' => ['Vélodrome', 'Marseille'],
            'Lyon' => ['Groupama Stadium', 'Lyon'],
            'Lille' => ['Pierre-Mauroy', 'Lille'],
            'Monaco' => ['Louis-II', 'Monaco'],
            'Rennes' => ['Roazhon Park', 'Rennes'],
            'Lens' => ['Bollaert-Delelis', 'Lens'],
            'Montpellier' => ['Stade de la Mosson', 'Montpellier'],
            'Nice' => ['Allianz Riviera', 'Nice'],
            'Strasbourg' => ['Stade de la Meinau', 'Strasbourg'],
            'Nantes' => ['Stade de la Beaujoire', 'Nantes'],
            'Bordeaux' => ['Matmut Atlantique', 'Bordeaux'],
            'Saint-Étienne' => ['Geoffroy-Guichard', 'Saint-Étienne'],
            'Reims' => ['Stade Auguste-Delaune', 'Reims'],
            'Angers' => ['Stade Raymond-Kopa', 'Angers'],
            'Metz' => ['Stade Saint-Symphorien', 'Metz'],
            'Brest' => ['Stade Francis-Le Blé', 'Brest'],
            'Lorient' => ['Stade du Moustoir', 'Lorient'],
            'Troyes' => ['Stade de l\'Aube', 'Troyes'],
            'Clermont' => ['Stade Gabriel-Montpied', 'Clermont-Ferrand']
        ];

        for ($i = 0; $i < 50; $i++) {
            $ticket = new Ticket();
            
            $homeTeam = $faker->randomElement($teams);
            $awayTeam = $faker->randomElement(array_diff($teams, [$homeTeam]));
            
            $stadiumInfo = $stadiums[$homeTeam] ?? ['Stade inconnu', 'Ville inconnue'];
            $stadiumName = $stadiumInfo[0];
            $stadiumCity = $stadiumInfo[1];
            
            $ticket->setHomeTeam($homeTeam)
                   ->setAwayTeam($awayTeam)
                   ->setDateTime($faker->dateTimeBetween('now', '+6 months'))
                   ->setPrice($faker->numberBetween(30, 200))
                   ->setStadium("$stadiumName, $stadiumCity")
                   ->setState($faker->randomElement(['en vente', 'réservé', 'vendu']));

            $manager->persist($ticket);
        }

        $manager->flush();
    }
}