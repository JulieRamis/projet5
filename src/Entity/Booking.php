<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=IngredientMenu::class, mappedBy="menu")
     */
    private $ingredientMenus;

    public function __construct()
    {
        $this->ingredientMenus = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|IngredientMenu[]
     */
    public function getIngredientMenus(): Collection
    {
        return $this->ingredientMenus;
    }

    /**
     * toString
     * @return string
     */
    public function __toString(){
        return (string) $this->ingredientMenusname;
    }


    public function addIngredientMenu(IngredientMenu $ingredientMenu): self
    {
        if (!$this->ingredientMenus->contains($ingredientMenu)) {
            $this->ingredientMenus[] = $ingredientMenu;
            $ingredientMenu->setMenu($this);
        }

        return $this;
    }

    public function removeIngredientMenu(IngredientMenu $ingredientMenu): self
    {
        if ($this->ingredientMenus->contains($ingredientMenu)) {
            $this->ingredientMenus->removeElement($ingredientMenu);
            // set the owning side to null (unless already changed)
            if ($ingredientMenu->getMenu() === $this) {
                $ingredientMenu->setMenu(null);
            }
        }

        return $this;
    }


}