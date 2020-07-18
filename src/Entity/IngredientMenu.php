<?php

namespace App\Entity;

use App\Repository\IngredientMenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientMenuRepository::class)
 */
class IngredientMenu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="ingredientMenus", cascade={"persist", "remove"})
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity=Booking::class, inversedBy="ingredientMenus")
     */
    private $menu;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getMenu(): ?Booking
    {
        return $this->menu;
    }

    public function setMenu(?Booking $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

}
