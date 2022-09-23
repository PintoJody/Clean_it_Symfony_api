<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbr_star = null;

    #[ORM\ManyToOne(inversedBy: 'avis_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'avis_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benne $benne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrStar(): ?int
    {
        return $this->nbr_star;
    }

    public function setNbrStar(int $nbr_star): self
    {
        $this->nbr_star = $nbr_star;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getBenneId(): ?Benne
    {
        return $this->benne_id;
    }

    public function setBenneId(?Benne $benne_id): self
    {
        $this->benne_id = $benne_id;

        return $this;
    }
}
