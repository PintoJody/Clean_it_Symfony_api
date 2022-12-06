<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\EtatBenneRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: EtatBenneRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['etatBenne:read']],
    denormalizationContext: ['groups' => ['etatBenne:write']],
    operations:[
        new Get(),
        new GetCollection(),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name'])]
class EtatBenne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['etatBenne:read', 'etatBenne:write', 'benne:read'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Benne::class)]
    private Collection $bennes;

    public function __construct()
    {
        $this->bennes = new ArrayCollection();
    }

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
            $benne->setEtat($this);
        }

        return $this;
    }

    public function removeBenne(Benne $benne): self
    {
        if ($this->bennes->removeElement($benne)) {
            // set the owning side to null (unless already changed)
            if ($benne->getEtat() === $this) {
                $benne->setEtat(null);
            }
        }

        return $this;
    }
}
