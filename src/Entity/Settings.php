<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SettingsRepository::class)
 */
class Settings
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
    private $key_settings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value_settings;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="settings")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeySettings(): ?string
    {
        return $this->key_settings;
    }

    public function setKeySettings(string $key_settings): self
    {
        $this->key_settings = $key_settings;

        return $this;
    }

    public function getValueSettings(): ?string
    {
        return $this->value_settings;
    }

    public function setValueSettings(?string $value_settings): self
    {
        $this->value_settings = $value_settings;

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
}
