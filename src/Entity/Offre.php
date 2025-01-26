<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(name: 'libelle', type: 'string', length: 500, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le libellé d\'offre')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;
    #[ORM\ManyToOne(targetEntity: Typeoffre::class)]
    #[ORM\JoinColumn(name: 'typeOffreId', referencedColumnName: 'id', nullable: false)]
    private ?Typeoffre $typeOffreId = null;
    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;
    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    private ?Pays $paysId = null;
    #[ORM\Column(name: 'dateCreation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $dateCreation = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @param \DateTimeInterface|null $dateCreation
     */
    public function setDateCreation(?\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Pays|null
     */
    public function getPaysId(): ?Pays
    {
        return $this->paysId;
    }

    /**
     * @return Typeoffre|null
     */
    public function getTypeOffreId(): ?Typeoffre
    {
        return $this->typeOffreId;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param Pays|null $paysId
     */
    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }

    /**
     * @param Typeoffre|null $typeOffreId
     */
    public function setTypeOffreId(?Typeoffre $typeOffreId): void
    {
        $this->typeOffreId = $typeOffreId;
    }
}
