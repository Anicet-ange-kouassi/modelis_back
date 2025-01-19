<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $nom = null;

    #[ORM\Column]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?string $fonction = null;

    #[ORM\Column]
    private ?string $sexe = null;

    #[ORM\Column]
    private ?string $dateNaissance = null;

    #[ORM\Column]
    private ?string $lieuNaissance = null;

    #[ORM\Column]
    private ?string $codePostal = null;

    #[ORM\Column]
    private ?string $ville = null;

    #[ORM\Column]
    private ?string $pays = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
