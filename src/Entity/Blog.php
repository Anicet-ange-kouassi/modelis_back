<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
#[ORM\Table(name: 'blog')]
#[OA\Schema(description: "Représentation d'une blog.")]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[OA\Property(description: 'Identifiant unique du blog.', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'utilisateurId', referencedColumnName: 'id', nullable: false)]
    #[OA\Property(description: 'Utilisateur ayant créé le blog')]
    private ?Utilisateur $utilisateurId = null;
    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['blog:read'])]
    private ?Pays $paysId = null;

    #[ORM\Column(type: 'string', length: 254)]
    #[Assert\NotBlank(message: 'Le libellé est obligatoire.')]
    #[OA\Property(description: 'Titre du blog')]
    private string $libelle;

    #[ORM\Column(type: 'text', length: 254, nullable: true)]
    #[OA\Property(description: 'Description du blog')]
    private ?string $description = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[OA\Property(description: "URL de l'image associée au blog")]
    private ?string $image = null;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[OA\Property(description: 'Date de création du blog', format: 'date-time')]
    private \DateTimeInterface $dateCreation;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUtilisateurId(): ?Utilisateur
    {
        return $this->utilisateurId;
    }

    public function setUtilisateurId(?Utilisateur $utilisateurId): void
    {
        $this->utilisateurId = $utilisateurId;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(?array $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return Pays|null
     */
    public function getPaysId(): ?Pays
    {
        return $this->paysId;
    }

    /**
     * @param Pays|null $paysId
     */
    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }
}
