<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column]
    private array $role = [];

    #[ORM\Column]
    private ?int $ban = null;

    #[ORM\Column]
    private ?int $nbr_trajet = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToMany(targetEntity: Badge::class, inversedBy: 'users')]
    private Collection $badge_id;

    #[ORM\ManyToMany(targetEntity: Localisation::class, inversedBy: 'users')]
    private Collection $localisation_id;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Avis::class)]
    private Collection $avis_id;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Signalement::class)]
    private Collection $signalement_id;

    public function __construct()
    {
        $this->badge_id = new ArrayCollection();
        $this->localisation_id = new ArrayCollection();
        $this->avis_id = new ArrayCollection();
        $this->signalement_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getBan(): ?int
    {
        return $this->ban;
    }

    public function setBan(int $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    public function getNbrTrajet(): ?int
    {
        return $this->nbr_trajet;
    }

    public function setNbrTrajet(int $nbr_trajet): self
    {
        $this->nbr_trajet = $nbr_trajet;

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
     * @return Collection<int, Badge>
     */
    public function getBadgeId(): Collection
    {
        return $this->badge_id;
    }

    public function addBadgeId(Badge $badgeId): self
    {
        if (!$this->badge_id->contains($badgeId)) {
            $this->badge_id->add($badgeId);
        }

        return $this;
    }

    public function removeBadgeId(Badge $badgeId): self
    {
        $this->badge_id->removeElement($badgeId);

        return $this;
    }

    /**
     * @return Collection<int, Localisation>
     */
    public function getLocalisationId(): Collection
    {
        return $this->localisation_id;
    }

    public function addLocalisationId(Localisation $localisationId): self
    {
        if (!$this->localisation_id->contains($localisationId)) {
            $this->localisation_id->add($localisationId);
        }

        return $this;
    }

    public function removeLocalisationId(Localisation $localisationId): self
    {
        $this->localisation_id->removeElement($localisationId);

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
            $avisId->setUserId($this);
        }

        return $this;
    }

    public function removeAvisId(Avis $avisId): self
    {
        if ($this->avis_id->removeElement($avisId)) {
            // set the owning side to null (unless already changed)
            if ($avisId->getUserId() === $this) {
                $avisId->setUserId(null);
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
            $signalementId->setUserId($this);
        }

        return $this;
    }

    public function removeSignalementId(Signalement $signalementId): self
    {
        if ($this->signalement_id->removeElement($signalementId)) {
            // set the owning side to null (unless already changed)
            if ($signalementId->getUserId() === $this) {
                $signalementId->setUserId(null);
            }
        }

        return $this;
    }
}
