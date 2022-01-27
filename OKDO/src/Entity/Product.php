<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_products_collection"})
     * @Groups({"get_products_categories_collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"get_products_collection"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"get_products_collection"})
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"get_products_collection"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=2000)
     * @Groups({"get_products_collection"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=2000)
     * @Groups({"get_products_collection"})
     */
    private $shoppingLink;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"get_products_collection"})
     */
    private $ageRange;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"get_products_collection"})
     */
    private $gender;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get_products_collection"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     * @Groups({"get_products_collection"})
     * @Groups({"get_products_categories_collection"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="products", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="product")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity=Age::class, mappedBy="product")
     */
    private $ages;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->ages = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getShoppingLink(): ?string
    {
        return $this->shoppingLink;
    }

    public function setShoppingLink(string $shoppingLink): self
    {
        $this->shoppingLink = $shoppingLink;

        return $this;
    }

    public function getAgeRange(): ?string
    {
        return $this->ageRange;
    }

    public function setAgeRange(?string $ageRange): self
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }


    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addProduct($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Age[]
     */
    public function getAges(): Collection
    {
        return $this->ages;
    }

    public function addAge(Age $age): self
    {
        if (!$this->ages->contains($age)) {
            $this->ages[] = $age;
            $age->addProduct($this);
        }

        return $this;
    }

    public function removeAge(Age $age): self
    {
        if ($this->ages->removeElement($age)) {
            $age->removeProduct($this);
        }

        return $this;
    }
}
