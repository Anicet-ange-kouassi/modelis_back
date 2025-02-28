<?php

namespace App\Entity;

use App\Repository\PersonnelleRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonnelleRepository::class)]
class Personnelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['personnelle:read'])]
    private ?Pays $paysId = null;

    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'siteId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['personnelle:read'])]
    private ?Site $siteId = null;

    #[ORM\Column(name: 'paysResidence', type: 'string', nullable: true)]
    #[Groups(['equipe:read'])]
    private ?string $paysResidence = null;

    #[ORM\Column(name: 'nationalite', type: 'string')]
    #[Groups(['equipe:read'])]
    private ?string $nationalite = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'string', length: 254)]
    #[Groups(['equipe:read'])]
    private ?string $nom = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'string', length: 254)]
    #[Groups(['equipe:read'])]
    private ?string $prenom = null;

    #[ORM\Column(name: 'sexe', type: 'string', nullable: true)]
    #[Groups(['equipe:read'])]
    private ?string $sexe = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['equipe:read'])]
    private ?string $email = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['equipe:read'])]
    private ?string $tel = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['equipe:read'])]
    private ?string $adresse = null;
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['equipe:read'])]
    private ?string $image = null;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $dateCreation = null;

    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getSiteId(): ?Site
    {
        return $this->siteId;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPaysResidence(): ?string
    {
        return $this->paysResidence;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setSiteId(?Site $siteId): void
    {
        $this->siteId = $siteId;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setNationalite(?string $nationalite): void
    {
        $this->nationalite = $nationalite;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPaysResidence(?string $paysResidence): void
    {
        $this->paysResidence = $paysResidence;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setSexe(?string $sexe): void
    {
        $this->sexe = $sexe;
    }

    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    public function getPaysId(): ?Pays
    {
        return $this->paysId;
    }

    public function setPaysId(?Pays $paysId): void
    {
        $this->paysId = $paysId;
    }
}
