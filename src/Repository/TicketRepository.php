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
    public function findTicketsEnVente(?string $myQuery = null): array
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->andWhere('t.state = :state')
            ->setParameter('state', 'en vente');
            if ($myQuery) {
                $queryBuilder->andWhere('t.homeTeam LIKE :team OR t.awayTeam LIKE :team OR t.competition LIKE :competition')  
                ->setParameter('team', '%'.$myQuery.'%')
                ->setParameter('competition', '%'.$myQuery.'%');
            }
            return $queryBuilder
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}