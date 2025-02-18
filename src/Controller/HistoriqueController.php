<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('', name: 'api_historique_list', methods: ['GET'])]
    #[OA\Get(
        path: '/api/historique',
        description: 'Retourne tous les historiques',
        summary: 'Liste des historiques',
        tags: ['Historique'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des historiques',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Historique::class))
                )
            ),
        ]
    )]
    public function index(HistoriqueRepository $historiqueRepository, SerializerInterface $serializer): JsonResponse
    {
        $historiques = $historiqueRepository->findAll();
        $jsonHistoriques = $serializer->serialize($historiques, 'json');

        return new JsonResponse($jsonHistoriques, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_historique_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/historique/{id}',
        description: "Retourne les détails d'un historique par son ID",
        summary: "Détails d'un historique",
        tags: ['Historique'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "ID de l'historique",
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Détails de l'historique",
                content: new OA\JsonContent(ref: new Model(type: Historique::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Historique introuvable'
            ),
        ]
    )]
    public function show(int $id, HistoriqueRepository $historiqueRepository, SerializerInterface $serializer): JsonResponse
    {
        $historique = $historiqueRepository->find($id);
        if (!$historique) {
            return new JsonResponse(['message' => 'Historique introuvable'], Response::HTTP_NOT_FOUND);
        }
        $jsonHistorique = $serializer->serialize($historique, 'json');

        return new JsonResponse($jsonHistorique, Response::HTTP_OK, [], true);
    }

    #[Route('', name: 'api_historique_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/historique',
        description: 'Crée un nouvel historique',
        summary: "Création d'un historique",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Historique::class))
        ),
        tags: ['Historique'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Historique créé avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();
        $historique = $serializer->deserialize($data, Historique::class, 'json');
        $em->persist($historique);
        $em->flush();

        return new JsonResponse(['message' => 'Historique créé avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_historique_update', methods: ['PUT'])]
    #[OA\Put(
        path: '/api/historique/{id}',
        description: 'Met à jour un historique existant',
        summary: "Mise à jour d'un historique",
        requestBody: new OA\RequestBody(
            description: "Données de l'historique à mettre à jour",
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Historique::class))
        ),
        tags: ['Historique'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "ID de l'historique à mettre à jour",
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Historique mis à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Historique introuvable'
            ),
        ]
    )]
    public function update(int $id, Request $request, HistoriqueRepository $historiqueRepository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $historique = $historiqueRepository->find($id);
        if (!$historique) {
            return new JsonResponse(['message' => 'Historique introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = $request->getContent();
        $serializer->deserialize($data, Historique::class, 'json', ['object_to_populate' => $historique]);
        $historique->setDateModification(new \DateTime());
        $em->flush();

        return new JsonResponse(['message' => 'Historique mis à jour avec succès'], Response::HTTP_OK);
    }
}
