<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'libelle', type: 'string', length: 500, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez renseigner le libellé du poste ou de la fonction occupée dans l'équipe")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;
    #[ORM\ManyToOne(targetEntity: Personne::class)]
    #[ORM\JoinColumn(name: 'personneId', referencedColumnName: 'id')]
    #[Assert\NotBlank(message: 'Veuillez choisir la personne')]
    private ?Personne $personneid = null;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['equipe:read'])]
    private ?Pays $paysId = null;
    #[ORM\Column(name: 'description', type: 'string', length: 254, nullable: true)]
    private ?string $description = null;
    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $datecreation;

    public function __construct()
    {
        $this->datecreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPersonneid(): ?Personne
    {
        return $this->personneid;
    }

    public function setPersonneid(?Personne $personneid): void
    {
        $this->personneid = $personneid;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
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

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
