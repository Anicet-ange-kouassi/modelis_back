<?php

namespace App\Entity;

use App\Repository\RealisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RealisationRepository::class)]
class Realisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Typeclient::class)]
    #[ORM\JoinColumn(name: 'typeclientId', referencedColumnName: 'id', nullable: false)]
    private ?Typeclient $typeclientId = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    private ?Pays $paysId = null;

    #[ORM\Column(name: 'libelle', type: 'string', length: 500, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le libellé de la realisation')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    private ?string $description = null;
    #[ORM\Column(name: 'dateDebut', type: 'date', nullable: true)]
    #[Assert\Date(message: 'Veuillez fournir une date de début valide.')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(name: 'dateFin', type: 'date', nullable: true)]
    #[Assert\Date(message: 'Veuillez fournir une date de fin valide.')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(name: 'enCours', type: 'boolean', options: ['default' => false])]
    private ?bool $enCours = false;

    #[ORM\Column(name: 'resultat', type: 'text', nullable: true)]
    private ?string $resultat = null;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $dateCreation = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEnCours(): ?bool
    {
        return $this->enCours;
    }

    public function getPaysId(): Pays
    {
        return $this->paysId;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function getTypeclientId(): Typeclient
    {
        return $this->typeclientId;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setEnCours(?bool $enCours): void
    {
        $this->enCours = $enCours;
    }

    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }

    public function setResultat(?string $resultat): void
    {
        $this->resultat = $resultat;
    }

    public function setTypeclientId(?Typeclient $typeclientId): void
    {
        $this->typeclientId = $typeclientId;
    }
}
