<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="booking")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Suite::class, inversedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $suite;

    /**
     * @ORM\ManyToOne(targetEntity=Establishment::class, inversedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $establishment;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEstablishment(): ?establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function getSuite(): ?suite
    {
        return $this->suite;
    }

    public function setSuite(?suite $suite): self
    {
        $this->suite = $suite;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
