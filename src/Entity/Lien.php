<?php

namespace App\Entity;

use App\Repository\LienRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[\AllowDynamicProperties] #[ORM\Entity(repositoryClass: LienRepository::class)]
class Lien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'siteId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['personnelle:read'])]
    private ?Site $siteId = null;
    #[ORM\Column(name: 'libelle', type: 'string', length: 254, nullable: true)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le libellé du poste ou de la fonction occupée dans le lien')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le libellé ne peut contenir que {{ limit }} caractères'
    )]
    private ?string $libelle = null;

    #[ORM\Column(name: 'lien', type: 'string', length: 254, nullable: true)]
    private ?string $lien = null;


    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCreation;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @return Site|null
     */
    public function getSiteId(): ?Site
    {
        return $this->siteId;
    }

    /**
     * @param Site|null $siteId
     */
    public function setSiteId(?Site $siteId): void
    {
        $this->siteId = $siteId;
    }

    /**
     * @param \DateTimeInterface $dateCreation
     */
    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
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
     * @return string|null
     */
    public function getLien(): ?string
    {
        return $this->lien;
    }

    /**
     * @param string|null $lien
     */
    public function setLien(?string $lien): void
    {
        $this->lien = $lien;
    }
}
