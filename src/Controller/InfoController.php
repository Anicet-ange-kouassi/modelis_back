<?php

namespace App\Controller;

use App\Entity\Info;
use App\Repository\InfoRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class InfoController extends AbstractController
{
    #[OA\Get(
        description: 'Retourne tous les infos enregistrés.',
        summary: 'Récupère la liste des infos',
        tags: ['Info'], responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des infos',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: new Model(type: Info::class)))
            ),
        ]
    )]
    #[Route('/api/info', name: 'app_info')]
    public function index(InfoRepository $infoRepository, SerializerInterface $serializer): JsonResponse
    {
        $infos = $infoRepository->findAll();
        $jsonInfoList = $serializer->serialize($infos, 'json');

        return new JsonResponse($jsonInfoList, Response::HTTP_OK, [], true);
    }
    #[\Symfony\Component\Routing\Annotation\Route('api/info/{id}', name: 'api_info_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/info/{id}',
        description: "Retourne les détails d'une info par son ID",
        summary: "Détails d'une info par son ID",
        tags: ['Info'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "ID de l'info",
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Détails de l'info",
                content: new OA\JsonContent(ref: new Model(type: Info::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Info introuvable'
            ),
        ]
    )]
    public function show(int $id, InfoRepository $infoRepository, SerializerInterface $serializer): JsonResponse
    {
        $info = $infoRepository->find($id);
        if (!$info) {
            return new JsonResponse(['message' => 'Info introuvable'], Response::HTTP_NOT_FOUND);
        }
        $jsonInfo = $serializer->serialize($info, 'json');

        return new JsonResponse($jsonInfo, Response::HTTP_OK, [], true);
    }
}
