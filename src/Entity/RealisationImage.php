<?php

namespace App\Entity;

use App\Repository\RealisationImageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[\AllowDynamicProperties]
#[ORM\Entity(repositoryClass: RealisationImageRepository::class)]
class RealisationImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Realisation::class)]
    #[ORM\JoinColumn(name: 'realisationId', referencedColumnName: 'id', nullable: false)]
    private ?Realisation $realisationId = null;
    #[ORM\Column(name: 'image', type: 'text', nullable: true)]
    private ?string $image = null;
    #[ORM\Column(name: 'date_creation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $date_creation = null;

    public function __construct()
    {
        $this->date_creation = new \DateTime();
    }

    public function setImage(Collection $image): void
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

    public function getDate_Creation(): \DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDate_Creation(\DateTimeInterface $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function getRealisationId(): ?Realisation
    {
        return $this->realisationId;
    }

    public function setRealisationId(?Realisation $realisationId): void
    {
        $this->realisationId = $realisationId;
    }
}
