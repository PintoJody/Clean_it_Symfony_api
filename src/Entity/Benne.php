<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BenneRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BenneRepository::class)]
#[ApiResource()]
class Benne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $capacite = null;

    #[ORM\ManyToOne(inversedBy: 'benne_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localisation $localisation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'benne_id', targetEntity: Avis::class, orphanRemoval: true)]
    private Collection $avis_id;

    #[ORM\OneToMany(mappedBy: 'benne_id', targetEntity: Signalement::class)]
    private Collection $signalement_id;

    #[ORM\ManyToOne(inversedBy: 'benne')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    public function __construct()
    {
        $this->avis_id = new ArrayCollection();
        $this->signalement_id = new ArrayCollection();
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

    public function getLocalisationId(): ?Localisation
    {
        return $this->localisation_id;
    }

    public function setLocalisationId(?Localisation $localisation_id): self
    {
        $this->localisation_id = $localisation_id;

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
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisId(): Collection
    {
        return $this->avis_id;
    }

    public function addAvisId(Avis $avisId): self
    {
        if (!$this->avis_id->contains($avisId)) {
            $this->avis_id->add($avisId);
            $avisId->setBenneId($this);
        }

        return $this;
    }

    public function removeAvisId(Avis $avisId): self
    {
        if ($this->avis_id->removeElement($avisId)) {
            // set the owning side to null (unless already changed)
            if ($avisId->getBenneId() === $this) {
                $avisId->setBenneId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Signalement>
     */
    public function getSignalementId(): Collection
    {
        return $this->signalement_id;
    }

    public function addSignalementId(Signalement $signalementId): self
    {
        if (!$this->signalement_id->contains($signalementId)) {
            $this->signalement_id->add($signalementId);
            $signalementId->setBenneId($this);
        }

        return $this;
    }

    public function removeSignalementId(Signalement $signalementId): self
    {
        if ($this->signalement_id->removeElement($signalementId)) {
            // set the owning side to null (unless already changed)
            if ($signalementId->getBenneId() === $this) {
                $signalementId->setBenneId(null);
            }
        }

        return $this;
    }

    public function getTypeId(): ?Type
    {
        return $this->type_id;
    }

    public function setTypeId(?Type $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

}
