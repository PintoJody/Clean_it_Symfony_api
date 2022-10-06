<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource()]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type_id', targetEntity: Benne::class)]
    private Collection $benne;

    public function __construct()
    {
        $this->benne = new ArrayCollection();
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
    public function getBenne(): Collection
    {
        return $this->benne;
    }

    public function addBenne(Benne $benne): self
    {
        if (!$this->benne->contains($benne)) {
            $this->benne->add($benne);
            $benne->setTypeId($this);
        }

        return $this;
    }

    public function removeBenne(Benne $benne): self
    {
        if ($this->benne->removeElement($benne)) {
            // set the owning side to null (unless already changed)
            if ($benne->getTypeId() === $this) {
                $benne->setTypeId(null);
            }
        }

        return $this;
    }
}
