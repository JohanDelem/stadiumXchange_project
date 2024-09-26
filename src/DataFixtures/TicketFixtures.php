<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ticket = new Ticket();
        $ticket->setAwayTeam('Rennes')
               ->setHomeTeam('PSG')
               ->setDateTime(new \DateTime('2024-09-27 21:00:00'))
               ->setPrice(100)
               ->setStadium('Parc des Princes, Paris')
               ->setState('en vente');


        $manager->persist($ticket);

        $manager->flush();
    }
}
