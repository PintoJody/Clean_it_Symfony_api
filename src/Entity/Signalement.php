<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\SignalementRepository;

#[ORM\Entity(repositoryClass: SignalementRepository::class)]
#[ApiResource()]
class Signalement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'signalement_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'signalement_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benne $benne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
