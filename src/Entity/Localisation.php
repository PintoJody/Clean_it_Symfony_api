<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['localisation:read']],
    denormalizationContext: ['groups' => ['localisation:write']],
    operations:[
        new Get(security: "is_granted('ROLE_USER')"),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_USER')"),
        new Put(security: "is_granted('ROLE_USER')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]

class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column]
    private ?float $latitude = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column]
    private ?float $longitude = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column(length: 255)]
    private ?string $cityName = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column(length: 255)]
    private ?string $departementName = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column(length: 255)]
    private ?string $regionName = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column(length: 255)]
    private ?string $departementCode = null;

    #[Groups(['localisation:write', 'localisation:read'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['localisation:write', 'localisation:read'])]
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
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getDepartementName(): ?string
    {
        return $this->departementName;
    }

    public function setDepartementName(string $departementName): self
    {
        $this->departementName = $departementName;

        return $this;
    }

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function setRegionName(string $regionName): self
    {
        $this->regionName = $regionName;

        return $this;
    }

    public function getDepartementCode(): ?int
    {
        return $this->departementCode;
    }

    public function setDepartementCode(int $departementCode): self
    {
        $this->departementCode = $departementCode;

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
