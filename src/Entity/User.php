<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, CardDetails>
     */
    #[ORM\OneToMany(targetEntity: CardDetails::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $cardDetails;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Ticket::class)]
    private Collection $ownedTickets;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(mappedBy: 'userIdSeller', targetEntity: Ticket::class)]
    private Collection $sellingTickets;

    /**
     * @var Collection<int, Selling>
     */
    #[ORM\OneToMany(targetEntity: Selling::class, mappedBy: 'seller')]
    private Collection $sellings;

    public function __construct()
    {
        $this->cardDetails = new ArrayCollection();
        $this->ownedTickets = new ArrayCollection();
        $this->sellingTickets = new ArrayCollection();
        $this->sellings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, CardDetails>
     */
    public function getCardDetails(): Collection
    {
        return $this->cardDetails;
    }

    public function addCardDetail(CardDetails $cardDetail): static
    {
        if (!$this->cardDetails->contains($cardDetail)) {
            $this->cardDetails->add($cardDetail);
            $cardDetail->setUser($this);
        }

        return $this;
    }

    public function removeCardDetail(CardDetails $cardDetail): static
    {
        if ($this->cardDetails->removeElement($cardDetail)) {
            // set the owning side to null (unless already changed)
            if ($cardDetail->getUser() === $this) {
                $cardDetail->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getOwnedTickets(): Collection
    {
        return $this->ownedTickets;
    }

    public function addOwnedTicket(Ticket $ticket): static
    {
        if (!$this->ownedTickets->contains($ticket)) {
            $this->ownedTickets->add($ticket);
            $ticket->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedTicket(Ticket $ticket): static
    {
        if ($this->ownedTickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getOwner() === $this) {
                $ticket->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getSellingTickets(): Collection
    {
        return $this->sellingTickets;
    }

    public function addSellingTicket(Ticket $ticket): static
    {
        if (!$this->sellingTickets->contains($ticket)) {
            $this->sellingTickets->add($ticket);
            $ticket->setUserIdSeller($this);
        }

        return $this;
    }

    public function removeSellingTicket(Ticket $ticket): static
    {
        if ($this->sellingTickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getUserIdSeller() === $this) {
                $ticket->setUserIdSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Selling>
     */
    public function getSellings(): Collection
    {
        return $this->sellings;
    }

    public function addSelling(Selling $selling): static
    {
        if (!$this->sellings->contains($selling)) {
            $this->sellings->add($selling);
            $selling->setUserIdSeller($this);
        }

        return $this;
    }

    public function removeSelling(Selling $selling): static
    {
        if ($this->sellings->removeElement($selling)) {
            // set the owning side to null (unless already changed)
            if ($selling->getUserIdSeller() === $this) {
                $selling->setUserIdSeller(null);
            }
        }

        return $this;
    }
}