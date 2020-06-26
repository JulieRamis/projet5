<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientRepository::class)
 */
class Ingredient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity=IngredientMenu::class, mappedBy="ingredient")
     */
    private $ingredientMenus;

    public function __construct()
    {
        $this->booking = new ArrayCollection();
        $this->ingredientMenus = new ArrayCollection();
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
     * @return Collection|IngredientMenu[]
     */
    public function getIngredientMenus(): Collection
    {
        return $this->ingredientMenus;
    }

    public function addIngredientMenu(IngredientMenu $ingredientMenu): self
    {
        if (!$this->ingredientMenus->contains($ingredientMenu)) {
            $this->ingredientMenus[] = $ingredientMenu;
            $ingredientMenu->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientMenu(IngredientMenu $ingredientMenu): self
    {
        if ($this->ingredientMenus->contains($ingredientMenu)) {
            $this->ingredientMenus->removeElement($ingredientMenu);
            // set the owning side to null (unless already changed)
            if ($ingredientMenu->getIngredient() === $this) {
                $ingredientMenu->setIngredient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
