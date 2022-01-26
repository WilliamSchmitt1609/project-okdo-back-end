<?php

namespace App\Entity;

use App\Repository\ProfilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfilesRepository::class)
 */
class Profiles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_profiles_collection"})
     * @Groups({"update_profiles_category_items"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"get_users_collection"})
     * @Groups({"get_profiles_collection"})
     * @Groups({"create_profiles_item"})
     * @Groups({"update_profiles_category_items"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"create_profiles_item"})
     * @Groups({"update_profiles_category_items"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"update_profiles_category_items"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="profiles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_profiles_collection"})
     * @Groups({"create_profiles_item"})
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="profiles")
     * @Groups({"update_profiles_category_items"})
     * @Groups({"get_profiles_collection"})
     * @Groups({"create_profiles_item"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addProfile($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProfile($this);
        }

        return $this;
    }
}
