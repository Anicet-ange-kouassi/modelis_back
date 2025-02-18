<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonneController extends AbstractController
{
    #[OA\Get(
        path: '/api/personne',
        description: 'Retourne tous les personnes',
        summary: 'Liste des personnes',
        tags: ['Personne'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des personnes',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Personne::class))
                )
            ),
        ]
    )]
    #[Route('/api/personne', methods: ['GET'])]
    public function index(PersonneRepository $personneRepository): JsonResponse
    {
        $personnes = $personneRepository->findAll();

        return $this->json($personnes);
    }

    #[OA\Post(
        path: '/api/personne',
        description: 'Crée une nouvelle personne',
        summary: "Création d'une personne",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Personne::class))
        ),
        tags: ['Personne'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Personne créé avec succès'
            ),
        ]
    )]
    #[Route('/api/personne', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $personne = new Personne();
        $personne->setNom($data['nom'] ?? null);
        $personne->setPrenom($data['prenom'] ?? null);
        $personne->setEmail($data['email'] ?? null);
        $personne->setDateNaissance(new \DateTime($data['dateNaissance'] ?? 'now'));

        $entityManager->persist($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personne created'], Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/api/personne/{id}',
        description: "Retourne les détails d'une personne par son ID",
        summary: "Détails d'une personne par son ID",
        tags: ['Personne'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la personne',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails de la  personne',
                content: new OA\JsonContent(ref: new Model(type: Personne::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Personne introuvable'
            ),
        ]
    )]
    #[Route('/api/personne/{id}', methods: ['GET'])]
    public function show(PersonneRepository $personneRepository, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($personne);
    }

    #[OA\Put(
        path: '/api/personne/{id}',
        description: 'Met à jour une personne existant',
        summary: "Mise à jour d'une personne",
        requestBody: new OA\RequestBody(
            description: 'Données de la personne à mettre à jour',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Personne::class))
        ),
        tags: ['Personne'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la personne à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Personne mise à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Personne introuvable'
            ),
        ]
    )]
    #[Route('/api/personne/{id}', methods: ['PUT'])]
    public function update(Request $request, PersonneRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $personne->setNom($data['nom'] ?? $personne->getNom());
        $personne->setPrenom($data['prenom'] ?? $personne->getPrenom());
        $personne->setEmail($data['email'] ?? $personne->getEmail());
        $personne->setDateNaissance(new \DateTime($data['dateNaissance'] ?? $personne->getDateNaissance()->format('Y-m-d')));

        $entityManager->flush();

        return $this->json(['status' => 'Personne updated']);
    }

    #[OA\Delete(
        path: '/api/personne/{id}',
        description: 'Supprime une personne.',
        summary: 'Suppression d\'une personne',
        tags: ['Personne'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la personne à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Personne supprimée avec succès'
            ),
        ]
    )]
    #[Route('/api/personne/{id}', methods: ['DELETE'])]
    public function delete(PersonneRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personne deleted']);
    }
}
