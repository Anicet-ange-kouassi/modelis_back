<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[\AllowDynamicProperties] #[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Typeservice::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Typeservice $typeservice = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['service:read'])]
    private ?Pays $paysId = null;
    #[ORM\Column(name: 'libelle', type: 'string', length: 254, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le type de libellé ')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;
    #[ORM\Column(name: 'icon', type: 'text', )]
    private ?string $icon = null;
    #[ORM\Column(name: 'lien', type: 'text', )]
    private ?string $lien = null;

    #[ORM\Column(name: 'description', type: 'string', length: 254, nullable: true)]
    private ?string $description = null;
    #[ORM\Column(name: 'image', type: 'text', )]
    private ?string $image = null;
    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCreation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function getTypeservice(): ?Typeservice
    {
        return $this->typeservice;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setLien(?string $lien): void
    {
        $this->lien = $lien;
    }

    public function setTypeservice(?Typeservice $typeservice): void
    {
        $this->typeservice = $typeservice;
    }

    /**
     * @param Pays|null $paysId
     */
    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }

    /**
     * @return Pays|null
     */
    public function getPaysId(): ?Pays
    {
        return $this->paysId;
    }
}
