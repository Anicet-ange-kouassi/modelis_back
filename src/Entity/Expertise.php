<?php

namespace App\Entity;

use App\Repository\ExpertiseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[\AllowDynamicProperties] #[ORM\Entity(repositoryClass: ExpertiseRepository::class)]
class Expertise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Pays::class, cascade: ['persist'], inversedBy: 'services')]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['expertise:read'])]
    private ?Pays $paysId = null;

    #[ORM\ManyToOne(targetEntity: Site::class, cascade: ['persist'], inversedBy: 'services')]
    #[ORM\JoinColumn(name: 'siteId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['expertise:read'])]
    private ?Site $siteId = null;
    #[ORM\Column(name: 'libelle', type: 'string', length: 254, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le type de libellé ')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;
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

    public function getSiteId(): ?Site
    {
        return $this->siteId;
    }

    public function setSiteId(?Site $siteId): void
    {
        $this->siteId = $siteId;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setLien(?string $lien): void
    {
        $this->lien = $lien;
    }

    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }

    public function getPaysId(): ?Pays
    {
        return $this->paysId;
    }
}
