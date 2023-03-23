<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateReservation;

    /**
     * @ORM\ManyToOne(targetEntity=Trajet::class, inversedBy="reservations")
     */
    private $trajet;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="reservations")
     */
    private $passager;

    public function __construct()
    {
        $this->passager = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPassager(): Collection
    {
        return $this->passager;
    }

    public function addPassager(User $passager): self
    {
        if (!$this->passager->contains($passager)) {
            $this->passager[] = $passager;
            $passager->setReservations($this);
        }

        return $this;
    }

    public function removePassager(User $passager): self
    {
        if ($this->passager->removeElement($passager)) {
            // set the owning side to null (unless already changed)
            if ($passager->getReservations() === $this) {
                $passager->setReservations(null);
            }
        }

        return $this;
    }
}
