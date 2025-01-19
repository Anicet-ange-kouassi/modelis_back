<?php

namespace App\Entity;

use App\Repository\TypelienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypelienRepository::class)]
class Typelien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(name: 'libelle', type: 'string', length: 254, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le libellé du poste ou de la fonction occupée dans le lien')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;
    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $datecreation;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->datecreation = new \DateTime();
    }

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDatecreation(): \DateTimeInterface
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTimeInterface $datecreation
     */
    public function setDatecreation(\DateTimeInterface $datecreation): void
    {
        $this->datecreation = $datecreation;
    }
}
