<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiFilter;
use App\State\UserRegisterProcessor;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\UserUpdatePasswordProcessor;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    operations:[
        new Get(),
        new GetCollection(),
        new Post(processor: UserRegisterProcessor::class),
        new Put(security: "is_granted('ROLE_USER') and object == user or is_granted('ROLE_ADMIN')", processor: UserUpdatePasswordProcessor::class),
        new Delete(security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') and object == user")
    ]
)]
#[ApiFilter(BooleanFilter::class, properties: ['ban'])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user:write', 'user:read'])]
    #[Assert\Email(message: 'Le mail {{ value }} n\'est pas un mail valide.')]
    #[Assert\NotBlank(message: 'L\'email doit être renseigné.')]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups('user:read')]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(message: 'Le mot de passe doit être renseigné.')]
    #[Groups('user:write')]
    private $plainPassword;

    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'Le nom doit faire {{ limit }} caractères minimum',
        maxMessage: 'Le nom doit faire {{ limit }} caractères maximum',
    )]
    #[Groups(['user:write', 'user:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[Assert\Type(
        type: 'integer',
        message: 'La valeur {{ value }} n\'est pas de type {{ type }}.',
    )]
    #[Groups(['user:write', 'user:read'])]
    #[ORM\Column(nullable: true)]
    private ?int $nbrTrajet = null;

    #[Groups(['user:write', 'user:read'])]
    #[ORM\Column]
    private ?bool $ban = null;

    #[ORM\ManyToMany(targetEntity: Badge::class, inversedBy: 'users')]
    #[Groups(['user:write', 'user:read', 'badge:read'])]
    private Collection $badges;

    #[ORM\ManyToMany(targetEntity: Localisation::class, inversedBy: 'users')]
    #[Groups(['user:write', 'user:read', 'localisation:read'])]
    private Collection $localisation;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Signalement::class)]
    private Collection $signalements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Avis::class)]
    private Collection $avis;


    public function __construct()
    {
        $this->badges = new ArrayCollection();
        $this->localisation = new ArrayCollection();
        $this->signalements = new ArrayCollection();
        $this->avis = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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

    public function getNbrTrajet(): ?int
    {
        return $this->nbrTrajet;
    }

    public function setNbrTrajet(?int $nbrTrajet): self
    {
        $this->nbrTrajet = $nbrTrajet;

        return $this;
    }

    public function isBan(): ?bool
    {
        return $this->ban;
    }

    public function setBan(bool $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    /**
     * @return Collection<int, Badge>
     */
    public function getBadges(): Collection
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badges->contains($badge)) {
            $this->badges->add($badge);
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        $this->badges->removeElement($badge);

        return $this;
    }

    /**
     * @return Collection<int, Localisation>
     */
    public function getLocalisation(): Collection
    {
        return $this->localisation;
    }

    public function addLocalisation(Localisation $localisation): self
    {
        if (!$this->localisation->contains($localisation)) {
            $this->localisation->add($localisation);
        }

        return $this;
    }

    public function removeLocalisation(Localisation $localisation): self
    {
        $this->localisation->removeElement($localisation);

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
            $signalement->setUser($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getUser() === $this) {
                $signalement->setUser(null);
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
            $avi->setUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser() === $this) {
                $avi->setUser(null);
            }
        }

        return $this;
    }


}
