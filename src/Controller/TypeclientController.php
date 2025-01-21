<?php

namespace App\Controller;

use App\Entity\Typeclient;
use App\Repository\TypeclientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TypeclientController extends AbstractController
{
    #[Route('/api/typeclient', name: 'type_client_index', methods: ['GET'])]
    public function index(TypeclientRepository $typeClientRepository, SerializerInterface $serializer): JsonResponse
    {
        $repository = $typeClientRepository->findAll();
        $jsonTypeClientList = $serializer->serialize($repository, 'json');

        return new JsonResponse($jsonTypeClientList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/typeclient/{id}', name: 'type_client_show', methods: ['GET'])]
    public function show(Typeclient $typeClient): Response
    {
        return $this->json($typeClient);
    }
}
