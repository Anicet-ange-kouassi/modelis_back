<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ClientController extends AbstractController
{
    #[Route('/api/client', name: 'api_client_list', methods: ['GET'])]
    public function index(ClientRepository $clientRepository, SerializerInterface $serializer): JsonResponse
    {
        $clients = $clientRepository->findAll();
        $jsonClients = $serializer->serialize($clients, 'json');

        return new JsonResponse($jsonClients, Response::HTTP_OK, [], true);
    }

    #[Route('/api/client/{id}', name: 'api_client_detail', methods: ['GET'])]
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
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $client = $serializer->deserialize($data, Client::class, 'json');

        $em->persist($client);
        $em->flush();

        return new JsonResponse(['message' => 'Client créé avec succès'], Response::HTTP_CREATED);
    }
}
