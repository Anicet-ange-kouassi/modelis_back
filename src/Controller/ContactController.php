<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Pays;
use App\Entity\Site;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactController extends AbstractController
{
    #[OA\Get(
        path: '/api/contact',
        description: 'Retourne tous les contacts',
        summary: 'Liste des contacts',
        tags: ['Contact'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des contacts',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Contact::class))
                )
            ),
        ]
    )]
    #[Route('/api/contact', name: 'api_contact_list', methods: ['GET'])]
    public function index(ContactRepository $contactRepository, SerializerInterface $serializer): JsonResponse
    {
        $contacts = $contactRepository->findAll();
        $jsonContactList = $serializer->serialize($contacts, 'json');

        return new JsonResponse($jsonContactList, Response::HTTP_OK, [], true);
    }
    #[OA\Get(
        path: '/api/contact/{payscode}',
        description: "Retourne les détails d'un contact par son ID",
        summary: "Détails d'un contact par son ID",
        tags: ['Contact'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du contact',
                content: new OA\JsonContent(ref: new Model(type: Contact::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Contact introuvable'
            ),
        ]
    )]
    #[Route('/api/contact/{payscode}', name: 'api_contact_code', methods: ['GET'])]
    public function getContactByPaysCode(
        Request $request,
        ContactRepository $contactRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        $paysCodeParam = $request->get('payscode'); // récupère le code depuis l'URL

        if ($paysCodeParam) {
            $contacts = $contactRepository->findByCountryCode($paysCodeParam);
        }

        $json = $serializer->serialize($contacts, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[OA\Post(
        path: '/api/contact',
        description: 'Crée un nouveau contact',
        summary: "Création d'un contact",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Contact::class))
        ),
        tags: ['Contact'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Contact créé avec succès'
            ),
        ]
    )]
    #[Route('/api/contact', name: 'api_contact_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pays = $em->getRepository(Pays::class)->find($data['paysId']);
        if (!$pays) {
            return new JsonResponse(['message' => 'Pays non trouvé'], 404);
        }
        $site = $em->getRepository(Site::class)->find($data['siteId']);
        if (!$site) {
            return new JsonResponse(['message' => 'Site non trouvé'], 404);
        }

        $contact = new Contact();
        $contact->setEmail($data['email']);
        $contact->setTel($data['tel']);
        $contact->setAdresse($data['adresse']);
        $contact->setDateCreation(new \DateTime());
        $contact->setPays($pays);
        $contact->setSite($site);

        $em->persist($contact);
        $em->flush();

        return $this->json(['message' => 'Contact créé avec succès'], 201);
    }
    #[OA\Get(
        path: '/api/contact/{id}',
        description: "Retourne les détails d'un contact par son ID",
        summary: "Détails d'un contact par son ID",
        tags: ['Contact'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du contact',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du contact',
                content: new OA\JsonContent(ref: new Model(type: Contact::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Contact introuvable'
            ),
        ]
    )]
    #[Route('/api/contact/{id}', name: 'api_contact_get', methods: ['GET'])]
    public function getById(int $id, ContactRepository $contactRepository, SerializerInterface $serializer): JsonResponse
    {
        $contact = $contactRepository->find($id);
        if (!$contact) {
            return new JsonResponse(['message' => 'Contact not found'], 404);
        }
        $jsonContact = $serializer->serialize($contact, 'json');

        return new JsonResponse($jsonContact, Response::HTTP_OK, []);
    }

    #[OA\Put(
        path: '/api/contact/{id}',
        description: 'Mise à jour d\'un contact existant par son ID',
        summary: "Mise à jour d'un contact",
        requestBody: new OA\RequestBody(
            description: 'Données du contact à mettre à jour',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Contact::class))
        ),
        tags: ['Contact'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du contact à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact mis à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Contact introuvable'
            ),
        ]
    )]
    #[Route('/api/contact/{id}', name: 'api_contact_update', methods: ['PUT'])]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Contact $contact = null,
    ): JsonResponse {
        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $contact->setEmail($data['email']);
        }
        if (isset($data['tel'])) {
            $contact->setTel($data['tel']);
        }
        if (isset($data['adresse'])) {
            $contact->setAdresse($data['adresse']);
        }

        $em->persist($contact);
        $em->flush();

        return $this->json(['message' => 'Contact modifié avec succès'], Response::HTTP_OK);
    }
    #[OA\Delete(
        path: '/api/contact/{id}',
        description: 'Supprimer un contact par son ID',
        summary: "Suppression d'un contact par son ID",
        tags: ['Contact'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du contact à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact supprimé avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Contact introuvable'
            ),
        ]
    )]

    #[Route('/api/contact/{id}', name: 'api_contact_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, ?Contact $contact = null): JsonResponse
    {
        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($contact);
        $em->flush();

        return $this->json(['message' => 'Contact supprimé avec succès'], Response::HTTP_OK);
    }
}
