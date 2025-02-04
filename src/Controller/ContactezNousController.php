<?php

namespace App\Controller;

use App\Entity\ContactezNous;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactezNousController extends AbstractController
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[OA\Post(
        path: '/api/contact/sendMail',
        description: "Cette API permet à un utilisateur d'envoyer un message via le formulaire de contact.",
        summary: 'Envoie un message de contact',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'nom', 'prenom', 'tel', 'objet', 'message'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'test@example.com'),
                    new OA\Property(property: 'nom', type: 'string', example: 'Dupont'),
                    new OA\Property(property: 'prenom', type: 'string', example: 'Jean'),
                    new OA\Property(property: 'tel', type: 'string', example: '0606060606'),
                    new OA\Property(property: 'objet', type: 'string', example: "Demande d'information"),
                    new OA\Property(property: 'message', type: 'string', example: 'Je voudrais en savoir plus sur votre service.'),
                ]
            )
        ),
        tags: ['Contactez-nous'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Message envoyé avec succès',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Message envoyé avec succès !'),
                    ]
                )
            ),
        ]
    )]
    #[Route('/api/contact/sendMail', name: 'app_contactez_nous', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // Décoder le JSON reçu
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['email'], $data['nom'], $data['prenom'], $data['tel'], $data['objet'], $data['message'])) {
            return new JsonResponse(['message' => 'Données incomplètes'], 400);
        }

        // Créer un nouvel objet ContactezNous
        $contact = new ContactezNous();
        $contact->setEmail($data['email']);
        $contact->setNom($data['nom']);
        $contact->setPrenom($data['prenom']);
        $contact->setTel($data['tel']);
        $contact->setObjet($data['objet']);
        $contact->setMessage($data['message']);
        $contact->setDateDenvoie(new \DateTime());

        // Valider l'entité
        $errors = $validator->validate($contact);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => 'Données invalides', 'errors' => (string) $errors], 400);
        }

        // Sauvegarder dans la base de données
        $entityManager->persist($contact);
        $entityManager->flush();

        // Envoi d'un email de confirmation
        $this->emailService->sendEmail(
            $contact->getEmail(),
            'Confirmation de contact',
            'Bonjour '.$contact->getNom().",\n\nNous avons bien reçu votre message. Nous vous répondrons bientôt."
        );

        return new JsonResponse(['message' => 'Message envoyé avec succès !']);
    }
}
