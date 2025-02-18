<?php

namespace App\Entity;

use App\Repository\BlogCommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[\AllowDynamicProperties] #[ORM\Entity(repositoryClass: BlogCommentaireRepository::class)]
#[ORM\Table(name: 'blog_commentaire')]
class BlogCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Blog::class)]
    #[ORM\JoinColumn(name: 'blogId', referencedColumnName: 'id', nullable: false)]
    #[Groups(['BlogCommentaire:read'])]
    private ?Blog $blogId = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'dateCreation', type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $dateCreation;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function getDateCreation(): \DateTimeInterface
    {
        return $this->dateCreation;
    }


    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setCommentaire(?string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getBlog(): ?Blog
    {
        return $this->blogId;
    }

    public function setBlog(?Blog $blogId): self
    {
        $this->blog = $blogId;

        return $this;
    }
}
