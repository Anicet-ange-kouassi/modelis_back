<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['realisation:read'])]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'siteId ', referencedColumnName: 'id', nullable: false)]
    #[Groups(['realisation:read'])]
    private ?Site $siteId = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['realisation:read'])]
    private ?string $image;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['realisation:read'])]
    private ?string $description;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups(['realisation:read'])]
    private \DateTimeInterface $dateCreation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setSiteId(?Site $siteId): void
    {
        $this->siteId = $siteId;
    }

    public function getSiteId(): ?Site
    {
        return $this->siteId;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
}
