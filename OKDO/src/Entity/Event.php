<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_profiles_collection"})
     * @Groups({"get_events_collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"create_profiles_item"})
     * @Groups({"get_profiles_collection"})
     * @Groups({"get_events_collection"})
     */
    private $label;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity=Profiles::class, mappedBy="event")
     */
    private $profiles;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="events")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"get_events_collection"})
     */
    private $value;

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection|Profiles[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profiles $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
            $profile->setEvent($this);
        }

        return $this;
    }

    public function removeProfile(Profiles $profile): self
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getEvent() === $this) {
                $profile->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->product->removeElement($product);

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
