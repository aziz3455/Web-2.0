<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Author;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $title = null;

    #[ORM\Column(type:"boolean")]
    private ?bool $published = null;

    #[ORM\Column(type:"string", length:255)]
    private ?string $categorie = null;

    #[ORM\Column(type:"datetime")]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy:"books")]
    #[ORM\JoinColumn(nullable:false)]
    private ?Author $author = null;

    // === Getters & Setters ===
    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function isPublished(): ?bool { return $this->published; }
    public function setPublished(bool $published): self { $this->published = $published; return $this; }
    public function getCategorie(): ?string { return $this->categorie; }
    public function setCategorie(string $categorie): self { $this->categorie = $categorie; return $this; }
    public function getDatePublication(): ?\DateTimeInterface { return $this->datePublication; }
    public function setDatePublication(\DateTimeInterface $datePublication): self { $this->datePublication = $datePublication; return $this; }
    public function getAuthor(): ?Author { return $this->author; }
    public function setAuthor(?Author $author): self { $this->author = $author; return $this; }
}
