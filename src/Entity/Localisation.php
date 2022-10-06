<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
#[ApiResource()]
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
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'localisation')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'localisation', targetEntity: Benne::class)]
    private Collection $bennes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->bennes = new ArrayCollection();
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $user->addLocalisation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeLocalisation($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Benne>
     */
    public function getBennes(): Collection
    {
        return $this->bennes;
    }

    public function addBenne(Benne $benne): self
    {
        if (!$this->bennes->contains($benne)) {
            $this->bennes->add($benne);
            $benne->setLocalisation($this);
        }

        return $this;
    }

    public function removeBenne(Benne $benne): self
    {
        if ($this->bennes->removeElement($benne)) {
            // set the owning side to null (unless already changed)
            if ($benne->getLocalisation() === $this) {
                $benne->setLocalisation(null);
            }
        }

        return $this;
    }
}
