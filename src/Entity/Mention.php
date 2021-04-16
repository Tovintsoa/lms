<?php

namespace App\Entity;

use App\Repository\MentionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MentionRepository::class)
 */
class Mention
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
    private $nomMention;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeMention;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionMention;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMention(): ?string
    {
        return $this->nomMention;
    }

    public function setNomMention(string $nomMention): self
    {
        $this->nomMention = $nomMention;

        return $this;
    }

    public function getCodeMention(): ?string
    {
        return $this->codeMention;
    }

    public function setCodeMention(string $codeMention): self
    {
        $this->codeMention = $codeMention;

        return $this;
    }

    public function getDescriptionMention(): ?string
    {
        return $this->descriptionMention;
    }

    public function setDescriptionMention(?string $descriptionMention): self
    {
        $this->descriptionMention = $descriptionMention;

        return $this;
    }
}
