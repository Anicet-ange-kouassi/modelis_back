<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/realisation')]
class RealisationController extends AbstractController
{
    #[Route('', name: 'api_realisation_list', methods: ['GET'])]
    #[OA\Get(
        path: '/api/realisation',
        description: 'Retourne toutes les réalisations avec leurs relations',
        summary: 'Liste des réalisations',
        tags: ['Réalisation'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des réalisations',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Realisation::class))
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Aucune réalisation trouvée'
            ),
        ]
    )]
    public function index(RealisationRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $realisations = $repository->findAllWithRelations();

        if (empty($realisations)) {
            return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        }

        $jsonData = $serializer->serialize($realisations, 'json', ['groups' => 'realisation:read']);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_realisation_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/realisation/{id}',
        description: "Retourne les détails d'une réalisation par son ID",
        summary: "Détails d'une réalisation",
        tags: ['Réalisation'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la réalisation',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails de la réalisation',
                content: new OA\JsonContent(ref: new Model(type: Realisation::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Réalisation introuvable'
            ),
        ]
    )]
    public function getRealisationWithImages(int $id, RealisationRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $realisation = $repository->find($id);

        if (!$realisation) {
            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonData = $serializer->serialize($realisation, 'json', ['groups' => 'realisation:read']);

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_realisation_update', methods: ['PUT'])]
    #[OA\Put(
        path: '/api/realisation/{id}',
        description: 'Met à jour une réalisation existante',
        summary: "Mise à jour d'une réalisation",
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Données de mise à jour de la réalisation',
            content: new OA\JsonContent(ref: new Model(type: Realisation::class))
        ),
        tags: ['Réalisation'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la réalisation à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Réalisation mise à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Réalisation introuvable'
            ),
        ]
    )]
    public function update(
        int $id,
        Request $request,
        RealisationRepository $repository,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
    ): JsonResponse {
        $realisation = $repository->find($id);
        if (!$realisation) {
            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        // Désérialise dans l'objet existant
        $serializer->deserialize($data, Realisation::class, 'json', ['object_to_populate' => $realisation]);

        $em->flush();

        return new JsonResponse(['message' => 'Réalisation mise à jour avec succès'], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'api_realisation_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/realisation/{id}',
        description: 'Supprime une réalisation par son ID',
        summary: "Suppression d'une réalisation",
        tags: ['Réalisation'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de la réalisation à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Réalisation supprimée avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Réalisation introuvable'
            ),
        ]
    )]
    public function delete(
        int $id,
        RealisationRepository $repository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $realisation = $repository->find($id);
        if (!$realisation) {
            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($realisation);
        $em->flush();

        return new JsonResponse(['message' => 'Réalisation supprimée avec succès'], Response::HTTP_OK);
    }
}
