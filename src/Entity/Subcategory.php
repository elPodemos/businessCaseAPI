<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubcategoryRepository::class)]
class Subcategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['allSubcategory', 'allCategory'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['allSubcategory', 'allCategory'])]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'subcategories')]
    #[Groups(['allSubcategory'])]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
