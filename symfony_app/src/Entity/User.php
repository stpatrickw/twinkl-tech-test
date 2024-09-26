<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * This can be replaced to separate entity,
     * but in order not to overcomplicate let it be hardcoded
     */
    #[Assert\NotBlank]
    #[Assert\Choice(['student', 'teacher', 'parent', 'private tutor'])]
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    private ?string $lastUsedIP = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLastUsedIP(): ?string
    {
        return $this->lastUsedIP;
    }

    public function setLastUsedIP(?string $lastUsedIP): void
    {
        $this->lastUsedIP = $lastUsedIP;
    }
}
