<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\SignalementRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SignalementRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['signalement:read']],
    denormalizationContext: ['groups' => ['signalement:write']],
    operations:[
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]

class Signalement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'Le nom doit faire {{ limit }} caractères minimum',
        maxMessage: 'Le nom doit faire {{ limit }} caractères maximum',
    )]
    #[Groups(['signalement:write', 'signalement:read'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['signalement:write', 'signalement:read', 'user:read'])]
    #[ORM\ManyToOne(inversedBy: 'signalements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Groups(['signalement:write', 'signalement:read', 'benne:read'])]
    #[ORM\ManyToOne(inversedBy: 'signalements')]
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
