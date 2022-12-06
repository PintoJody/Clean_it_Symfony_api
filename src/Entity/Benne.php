<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BenneRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: BenneRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['benne:read']],
    denormalizationContext: ['groups' => ['benne:write']],
    operations:[
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['type.name', 'localisation.adress'])]
class Benne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['benne:read'])]
    private ?int $id = null;

    #[Groups(['benne:write', 'benne:read'])]
    #[ORM\Column(length: 255)]
    private ?string $capacite = null;

    #[Groups(['benne:write', 'benne:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['benne:write', 'benne:read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[Groups(['benne:write', 'benne:read', 'localisation:read'])]
    #[ORM\ManyToOne(inversedBy: 'bennes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localisation $localisation = null;

    #[Groups(['benne:write', 'benne:read', 'type:read'])]
    #[ORM\ManyToOne(inversedBy: 'bennes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[Groups(['signalement:read', 'benne:read'])]
    #[ORM\OneToMany(mappedBy: 'benne', targetEntity: Signalement::class)]
    private Collection $signalements;

    #[Groups(['benne:write', 'benne:read', 'avis:read'])]
    #[ORM\OneToMany(mappedBy: 'benne', targetEntity: Avis::class)]
    private Collection $avis;

    #[Groups(['benne:write', 'benne:read', 'etatBenne:read'])]
    #[ORM\ManyToOne(inversedBy: 'bennes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatBenne $etat = null;

    public function __construct()
    {
        $this->signalements = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapacite(): ?string
    {
        return $this->capacite;
    }

    public function setCapacite(string $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): self
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements->add($signalement);
            $signalement->setBenne($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getBenne() === $this) {
                $signalement->setBenne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setBenne($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getBenne() === $this) {
                $avi->setBenne(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?EtatBenne
    {
        return $this->etat;
    }

    public function setEtat(?EtatBenne $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
