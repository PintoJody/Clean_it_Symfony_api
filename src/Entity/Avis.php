<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['avis:read']],
    denormalizationContext: ['groups' => ['avis:write']],
    operations:[
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]

class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['avis:write', 'avis:read'])]
    #[ORM\Column]
    private ?int $nbrStar = null;

    #[Groups(['avis:write', 'avis:read', 'user:read'])]
    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Groups(['avis:write', 'avis:read', 'benne:read'])]
    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benne $benne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrStar(): ?int
    {
        return $this->nbrStar;
    }

    public function setNbrStar(int $nbrStar): self
    {
        $this->nbrStar = $nbrStar;

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

    public function getBenne(): ?Benne
    {
        return $this->benne;
    }

    public function setBenne(?Benne $benne): self
    {
        $this->benne = $benne;

        return $this;
    }
}
