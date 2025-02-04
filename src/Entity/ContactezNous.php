<?php

namespace App\Entity;

use App\Repository\ContactezNousRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactezNousRepository::class)]
#[ORM\Table(name: 'contactez_nous')]
#[OA\Schema(description: "Représentation d'un message de contact envoyé par un utilisateur.")]
class ContactezNous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[OA\Property(description: 'Identifiant unique du message de contact.', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[OA\Property(description: "Adresse email de l'utilisateur qui envoie le message.", type: 'string', format: 'email', example: 'test@example.com')]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[OA\Property(description: "Numéro de téléphone de l'utilisateur.", type: 'string', example: '0606060606')]
    private ?string $tel = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[OA\Property(description: 'Objet du message.', type: 'string', example: "Demande d'information")]
    private ?string $objet = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[OA\Property(description: "Contenu du message envoyé par l'utilisateur.", type: 'string', example: 'Je souhaiterais en savoir plus sur vos services.')]
    private ?string $message = null;

    #[ORM\Column(type: 'string', length: 254)]
    #[OA\Property(description: "Nom de l'utilisateur.", type: 'string', example: 'Dupont')]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 254)]
    #[OA\Property(description: "Prénom de l'utilisateur.", type: 'string', example: 'Jean')]
    private ?string $prenom = null;

    #[ORM\Column(name: 'dateDenvoie', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[OA\Property(description: "Date et heure d'envoi du message.", type: 'string', format: 'date-time', example: '2024-01-30T12:00:00Z')]
    private \DateTimeInterface $dateDenvoie;

    public function __construct()
    {
        $this->dateDenvoie = new \DateTime();
    }

    // Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(?string $objet): void
    {
        $this->objet = $objet;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getDateDenvoie(): \DateTimeInterface
    {
        return $this->dateDenvoie;
    }

    public function setDateDenvoie(\DateTime $param): \DateTime|\DateTimeInterface
    {
        return $this->dateDenvoie;
    }
}
