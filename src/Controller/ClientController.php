<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    #[OA\Get(
        path: '/api/client',
        description: 'Retourne tous les clients',
        summary: 'Liste des historiques',
        tags: ['Client'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des clients',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Client::class))
                )
            ),
        ]
    )]
    #[Route('/api/client', name: 'api_client_list', methods: ['GET'])]
    public function index(ClientRepository $clientRepository, SerializerInterface $serializer): JsonResponse
    {
        $clients = $clientRepository->findAll();
        $jsonClients = $serializer->serialize($clients, 'json');

        return new JsonResponse($jsonClients, Response::HTTP_OK, [], true);
    }

    #[Route('/api/client/{id}', name: 'api_client_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/client/{id}',
        description: "Retourne les détails d'un client par son ID",
        summary: "Détails d'un client par son ID",
        tags: ['Client'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du client',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du client',
                content: new OA\JsonContent(ref: new Model(type: Client::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Client introuvable'
            ),
        ]
    )]
    public function show(int $id, ClientRepository $clientRepository, SerializerInterface $serializer): JsonResponse
    {
        $client = $clientRepository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonClient = $serializer->serialize($client, 'json');

        return new JsonResponse($jsonClient, Response::HTTP_OK, [], true);
    }

    #[Route('/api/client', name: 'api_client_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/client',
        description: 'Crée un nouveau client',
        summary: "Création d'un client",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Client::class))
        ),
        tags: ['Client'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Client créé avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $client = $serializer->deserialize($data, Client::class, 'json');

        $em->persist($client);
        $em->flush();

        return new JsonResponse(['message' => 'Client créé avec succès'], Response::HTTP_CREATED);
    }
}
