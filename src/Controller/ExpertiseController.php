<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Expertise;
use App\Repository\ExpertiseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ExpertiseController extends AbstractController
{
    // --- GET: Liste des expertises ---
    #[Route('/api/expertise', name: 'api_expertise_list', methods: ['GET'])]
    #[OA\Get(
        path: '/api/expertise',
        description: 'Retourne la liste complète des expertises',
        summary: 'Liste des expertises',
        tags: ['Expertise'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des expertises',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Expertise::class))
                )
            ),
        ]
    )]
    public function index(ExpertiseRepository $serviceRepository, SerializerInterface $serializer): JsonResponse
    {
        $service = $serviceRepository->findAll();
        $jsonServiceList = $serializer->serialize($service, 'json');

        return new JsonResponse($jsonServiceList, Response::HTTP_OK, [], true);
    }

    // --- GET: Détails d'un expertise ---
    #[Route('/api/expertise/{id}', name: 'api_expertise_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/expertise/{id}',
        description: "Retourne les détails d'un expertise par son ID",
        summary: "Détails d'un expertise",
        tags: ['Expertise'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du expertise',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du expertise',
                content: new OA\JsonContent(ref: new Model(type: Expertise::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Expertise introuvable'
            ),
        ]
    )]
    public function getServiceById(int $id, ExpertiseRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Expertise introuvable'], Response::HTTP_NOT_FOUND);
        }
        $jsonData = $serializer->serialize($service, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    // --- POST: Création d'un expertise ---
    #[Route('/api/expertise', name: 'api_expertise_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/expertise',
        description: 'Crée un nouveau expertise',
        summary: "Création d'un expertise",
        requestBody: new OA\RequestBody(
            description: 'Données du expertise à créer',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Expertise::class))
        ),
        tags: ['Expertise'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Expertise créé avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        // Récupère les données JSON envoyées dans la requête et les convertit en tableau
        $data = json_decode($request->getContent(), true);

        // Récupère l'entité Pays existante via son identifiant envoyé dans le JSON
        $pays = $em->getRepository(Pays::class)->find($data['paysId']['id']);

        // Crée une nouvelle instance de Expertise et assigne les entités récupérées
        $service = new Expertise();
        $service->setPaysId($pays);
        $service->setSiteId($pays);
        $service->setLibelle($data['libelle']);
        $service->setDescription($data['description']);
        $service->setDateCreation(new \DateTime());
        $service->setImage($data['image']);
        $service->setLien($data['lien']);

        // Persiste l'entité Expertise en base de données
        $em->persist($service);
        $em->flush();

        // Retourne une réponse JSON indiquant que le expertise a été créé avec succès
        return new JsonResponse(['message' => 'Expertise créé avec succès'], Response::HTTP_CREATED);
    }


    // --- PUT: Mise à jour d'un expertise ---
    #[Route('/api/expertise/{id}', name: 'api_expertise_update', methods: ['PUT'])]
    #[OA\Put(
        path: '/api/expertise/{id}',
        description: 'Met à jour un expertise existant par son ID',
        summary: "Mise à jour d'un expertise",
        requestBody: new OA\RequestBody(
            description: 'Données du expertise à mettre à jour',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Expertise::class))
        ),
        tags: ['Expertise'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du expertise à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Expertise mis à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Expertise introuvable'
            ),
        ]
    )]
    public function update(int $id, Request $request, ExpertiseRepository $repository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Expertise introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = $request->getContent();
        $serializer->deserialize($data, Expertise::class, 'json', ['object_to_populate' => $service]);
        $em->flush();

        return new JsonResponse(['message' => 'Expertise mis à jour avec succès'], Response::HTTP_OK);
    }

    // --- DELETE: Suppression d'un expertise ---
    #[Route('/{id}', name: 'api_expertise_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/expertise/{id}',
        description: 'Supprime un expertise par son ID',
        summary: "Suppression d'un expertise",
        tags: ['Expertise'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du expertise à supprimer',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Expertise supprimé avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Expertise introuvable'
            ),
        ]
    )]
    public function delete(int $id, ExpertiseRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $service = $repository->find($id);
        if (!$service) {
            return new JsonResponse(['message' => 'Expertise introuvable'], Response::HTTP_NOT_FOUND);
        }
        $em->remove($service);
        $em->flush();

        return new JsonResponse(['message' => 'Expertise supprimé avec succès'], Response::HTTP_OK);
    }
}
