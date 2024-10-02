<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /**
     * @return Ticket[] Returns an array of Ticket objects with state 'en vente'
     */
    public function findTicketsEnVente(?string $team = null): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.state = :state')
            ->setParameter('state', 'en vente');
            if ($team) {
                $queryBuilder->andWhere('t.homeTeam LIKE :team OR t.awayTeam LIKE :team')  
                ->setParameter('team', '%'.$team.'%');
            }
            return $queryBuilder
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}