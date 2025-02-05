<?php

namespace App\Entity;

use App\Repository\RealisationImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[\AllowDynamicProperties]
#[ORM\Entity(repositoryClass: RealisationImageRepository::class)]
class RealisationImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Realisation::class, inversedBy: 'images')]
    #[JoinColumn(name: 'realisationId', referencedColumnName: 'id', nullable: false)]
    #[MaxDepth(1)]
    private ?Realisation $realisationId = null;

    #[ORM\Column(name: 'image', type: 'string', length: 255)]
    #[Groups(['realisation:read'])]
    private string $image;
    #[ORM\Column(name: 'date_creation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $dateCreation = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->datecreation = $dateCreation;
    }

    public function getRealisationId(): ?Realisation
    {
        return $this->realisationId;
    }

    public function setRealisationId(?Realisation $realisationId): void
    {
        $this->realisationId = $realisationId;
    }

    public function setRealisation(Realisation $realisation): void
    {
        $this->realisationId = $realisation;
    }
}
