<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['contact:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $tel = null;

    #[ORM\Column(type: 'text')]
    private ?string $adresse = null;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCreation;

    #[ORM\ManyToOne(targetEntity: Pays::class)]
    #[ORM\JoinColumn(name: 'paysId', referencedColumnName: 'id', nullable: false)]
    #[Groups(['contact:read'])]
    private ?Pays $pays = null;

    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'siteId', referencedColumnName: 'id', nullable: false)]
    #[Groups(['contact:read'])]
    private ?Site $site = null;

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setSite(?Site $site): void
    {
        $this->site = $site;
    }

    public function setDateCreation(?\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setPays(?Pays $pays): void
    {
        $this->pays = $pays;
    }

    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }
}
