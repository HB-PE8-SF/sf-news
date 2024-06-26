<?php

namespace App\Entity;

use App\Repository\NewsletterEmailRepository;
use App\Validator\IsNotSpam;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewsletterEmailRepository::class)]
#[ORM\UniqueConstraint('UNIQUE_EMAIL_IDX', fields: ['email'])]
#[UniqueEntity('email', message: "Cet email existe déjà dans la newsletter")]
class NewsletterEmail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Cette valeur est obligatoire")]
    #[Assert\Email(message: "Cette adresse n'est pas une adresse email")]
    #[IsNotSpam]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
