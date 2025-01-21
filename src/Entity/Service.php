<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Typeservice::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Typeservice $typeservice = null;
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

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getLien(): ?string
    {
        return $this->lien;
    }

    /**
     * @return Typeservice|null
     */
    public function getTypeservice(): ?Typeservice
    {
        return $this->typeservice;
    }

    /**
     * @param \DateTimeInterface $datecreation
     */
    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string|null $icon
     */
    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @param string|null $lien
     */
    public function setLien(?string $lien): void
    {
        $this->lien = $lien;
    }

    /**
     * @param Typeservice|null $typeservice
     */
    public function setTypeservice(?Typeservice $typeservice): void
    {
        $this->typeservice = $typeservice;
    }
}
