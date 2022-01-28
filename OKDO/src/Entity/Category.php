<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"create_profiles_item"})
     * @Groups({"get_products_collection"})
     * @Groups({"get_profiles_collection"})
     * 
     */
    private $id;

    
    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"create_profiles_item"})
     * @Groups({"get_products_collection"})
     * @Groups({"get_profiles_collection"})
     * @Groups({"get_categories_collection"})
     */
    private $name;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Profiles::class, inversedBy="categories")
     */
    private $profiles;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="category")
     * @Groups({"get_products_categories_collection"})
     */
    private $products;


    public function __construct()
    {
        $this->profiles = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->filterTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): ?int
    {
        $this->id = $id;
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
        }

        return $this;
    }

    public function removeProfile(Profiles $profile): self
    {
        $this->profiles->removeElement($profile);

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    
}
