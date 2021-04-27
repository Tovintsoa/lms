<?php

namespace App\Entity;

use App\Repository\ChapitreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapitreRepository::class)
 */
class Chapitre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleChapitre;

    /**
     * @ORM\Column(type="text")
     */
    private $contenuChapitre;

    /**
     * @ORM\ManyToOne(targetEntity=Cours::class, inversedBy="chapitres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleChapitre(): ?string
    {
        return $this->libelleChapitre;
    }

    public function setLibelleChapitre(string $libelleChapitre): self
    {
        $this->libelleChapitre = $libelleChapitre;

        return $this;
    }

    public function getContenuChapitre(): ?string
    {
        return $this->contenuChapitre;
    }

    public function setContenuChapitre(string $contenuChapitre): self
    {
        $this->contenuChapitre = $contenuChapitre;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
