<?php

namespace App\Entity;

use App\Repository\SellingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SellingRepository::class)]
class Selling
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ticketId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userIdPurchaser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CardDetails $cardDetailId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketId(): ?User
    {
        return $this->ticketId;
    }

    public function setTicketId(?User $ticketId): static
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    public function getUserIdPurchaser(): ?User
    {
        return $this->userIdPurchaser;
    }

    public function setUserIdPurchaser(?User $userIdPurchaser): static
    {
        $this->userIdPurchaser = $userIdPurchaser;

        return $this;
    }

    public function getCardDetailId(): ?CardDetails
    {
        return $this->cardDetailId;
    }

    public function setCardDetailId(?CardDetails $cardDetailId): static
    {
        $this->cardDetailId = $cardDetailId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
