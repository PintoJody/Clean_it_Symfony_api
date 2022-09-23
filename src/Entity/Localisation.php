<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city_name = null;

    #[ORM\Column(length: 255)]
    private ?string $departement_name = null;

    #[ORM\Column(length: 255)]
    private ?string $region_name = null;

    #[ORM\Column]
    private ?int $departement_code = null;

    #[ORM\Column]
    private ?int $region_code = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'localisation_id')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'localisation_id', targetEntity: Benne::class)]
    private Collection $benne_id;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->benne_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->city_name;
    }

    public function setCityName(string $city_name): self
    {
        $this->city_name = $city_name;

        return $this;
    }

    public function getDepartementName(): ?string
    {
        return $this->departement_name;
    }

    public function setDepartementName(string $departement_name): self
    {
        $this->departement_name = $departement_name;

        return $this;
    }

    public function getRegionName(): ?string
    {
        return $this->region_name;
    }

    public function setRegionName(string $region_name): self
    {
        $this->region_name = $region_name;

        return $this;
    }

    public function getDepartementCode(): ?int
    {
        return $this->departement_code;
    }

    public function setDepartementCode(int $departement_code): self
    {
        $this->departement_code = $departement_code;

        return $this;
    }

    public function getRegionCode(): ?int
    {
        return $this->region_code;
    }

    public function setRegionCode(int $region_code): self
    {
        $this->region_code = $region_code;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addLocalisationId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeLocalisationId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Benne>
     */
    public function getBenneId(): Collection
    {
        return $this->benne_id;
    }

    public function addBenneId(Benne $benneId): self
    {
        if (!$this->benne_id->contains($benneId)) {
            $this->benne_id->add($benneId);
            $benneId->setLocalisationId($this);
        }

        return $this;
    }

    public function removeBenneId(Benne $benneId): self
    {
        if ($this->benne_id->removeElement($benneId)) {
            // set the owning side to null (unless already changed)
            if ($benneId->getLocalisationId() === $this) {
                $benneId->setLocalisationId(null);
            }
        }

        return $this;
    }
}
