<?php

namespace App\Controller;

use App\Entity\Personnelle;
use App\Repository\PersonnelleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonnelleController extends AbstractController
{
    #[OA\Get(
        path: '/api/personnelle',
        description: 'Retourne tous les personnelles',
        summary: 'Liste des personnelles',
        tags: ['Personnelle'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des personnelles',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Personnelle::class))
                )
            ),
        ]
    )]
    #[Route('/api/personnelle', methods: ['GET'])]
    public function index(PersonnelleRepository $personneRepository): JsonResponse
    {
        $personnes = $personneRepository->findAll();

        return $this->json($personnes);
    }

    #[OA\Post(
        path: '/api/personnelle',
        description: 'Crée un nouvel personnel',
        summary: "Création d'un personnel",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Personnelle::class))
        ),
        tags: ['Personnelle'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Personnelle créé avec succès'
            ),
        ]
    )]
    #[Route('/api/personnelle', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $personne = new Personnelle();
        $personne->setNom($data['nom'] ?? null);
        $personne->setPrenom($data['prenom'] ?? null);
        $personne->setEmail($data['email'] ?? null);

        $entityManager->persist($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personnelle created'], Response::HTTP_CREATED);
    }

    #[OA\Get(
        path: '/api/personnelle/{id}',
        description: "Retourne les détails d'une personnelle par son ID",
        summary: "Détails d'une personnelle par son ID",
        tags: ['Personnelle'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la personnelle',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails de la  personnelle',
                content: new OA\JsonContent(ref: new Model(type: Personnelle::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Personnelle introuvable'
            ),
        ]
    )]
    #[Route('/api/personnelle/{id}', methods: ['GET'])]
    public function show(PersonnelleRepository $personneRepository, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personnelle not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($personne);
    }

    #[OA\Put(
        path: '/api/personnelle/{id}',
        description: 'Met à jour un personnelle existant',
        summary: "Mise à jour d'un personnelle",
        requestBody: new OA\RequestBody(
            description: 'Données du personnelle à mettre à jour',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Personnelle::class))
        ),
        tags: ['Personnelle'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du personnel à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Personnelle mise à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Personnel introuvable'
            ),
        ]
    )]
    #[Route('/api/personnelle/{id}', methods: ['PUT'])]
    public function update(Request $request, PersonnelleRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personnelle not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $personne->setNom($data['nom'] ?? $personne->getNom());
        $personne->setPrenom($data['prenom'] ?? $personne->getPrenom());
        $personne->setEmail($data['email'] ?? $personne->getEmail());
        $personne->setTelephone($data['telephone'] ?? $personne->getTelephone());
        $personne->setAdresse($data['adresse'] ?? $personne->getAdresse());
        $personne->setVille($data['ville'] ?? $personne->getVille());
        $personne->setPays($data['pays'] ?? $personne->getPays());
        $personne->setSiteId($data['siteId'] ?? $personne->getSiteId());
        $entityManager->flush();

        return $this->json(['status' => 'Personnelle updated']);
    }

    #[OA\Delete(
        path: '/api/personnelle/{id}',
        description: 'Supprime un personnel.',
        summary: 'Suppression d\'un personnel',
        tags: ['Personnelle'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du personnel à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Personnel supprimée avec succès'
            ),
        ]
    )]
    #[Route('/api/personnelle/{id}', methods: ['DELETE'])]
    public function delete(PersonnelleRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personnelle not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personnelle deleted']);
    }
}
