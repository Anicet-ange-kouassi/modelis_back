<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/service')]
final class ServiceController extends AbstractController
{
    // --- GET: Liste des services ---
    #[Route('', name: 'api_service_list', methods: ['GET'])]
    #[OA\Get(
        path: '/api/service',
        description: 'Retourne la liste complète des services',
        summary: 'Liste des services',
        tags: ['Service'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des services',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Service::class))
                )
            ),
        ]
    )]
    public function index(ServiceRepository $serviceRepository, SerializerInterface $serializer): JsonResponse
    {
        $service = $serviceRepository->findAll();
        $jsonServiceList = $serializer->serialize($service, 'json');

        return new JsonResponse($jsonServiceList, Response::HTTP_OK, [], true);
    }

    // --- GET: Détails d'un service ---
    #[Route('/{id}', name: 'api_service_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/service/{id}',
        description: "Retourne les détails d'un service par son ID",
        summary: "Détails d'un service",
        tags: ['Service'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du service',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du service',
                content: new OA\JsonContent(ref: new Model(type: Service::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Service introuvable'
            ),
        ]
    )]
    public function getServiceById(int $id, ServiceRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Service introuvable'], Response::HTTP_NOT_FOUND);
        }
        $jsonData = $serializer->serialize($service, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    // --- POST: Création d'un service ---
    #[Route('', name: 'api_service_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/service',
        description: 'Crée un nouveau service',
        summary: "Création d'un service",
        requestBody: new OA\RequestBody(
            description: 'Données du service à créer',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Service::class))
        ),
        tags: ['Service'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Service créé avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();
        $service = $serializer->deserialize($data, Service::class, 'json');
        $em->persist($service);
        $em->flush();

        return new JsonResponse(['message' => 'Service créé avec succès'], Response::HTTP_CREATED);
    }

    // --- PUT: Mise à jour d'un service ---
    #[Route('/{id}', name: 'api_service_update', methods: ['PUT'])]
    #[OA\Put(
        path: '/api/service/{id}',
        description: 'Met à jour un service existant par son ID',
        summary: "Mise à jour d'un service",
        requestBody: new OA\RequestBody(
            description: 'Données du service à mettre à jour',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Service::class))
        ),
        tags: ['Service'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du service à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Service mis à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Service introuvable'
            ),
        ]
    )]
    public function update(int $id, Request $request, ServiceRepository $repository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Service introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = $request->getContent();
        $serializer->deserialize($data, Service::class, 'json', ['object_to_populate' => $service]);
        $em->flush();

        return new JsonResponse(['message' => 'Service mis à jour avec succès'], Response::HTTP_OK);
    }

    // --- DELETE: Suppression d'un service ---
    #[Route('/{id}', name: 'api_service_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/service/{id}',
        description: 'Supprime un service par son ID',
        summary: "Suppression d'un service",
        tags: ['Service'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du service à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Service supprimé avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Service introuvable'
            ),
        ]
    )]
    public function delete(int $id, ServiceRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Service introuvable'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($service);
        $em->flush();

        return new JsonResponse(['message' => 'Service supprimé avec succès'], Response::HTTP_OK);
    }
}
