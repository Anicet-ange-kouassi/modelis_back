<?php

namespace App\Controller;

use App\Entity\Lien;
use App\Repository\LienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class LienController extends AbstractController
{
    #[\Symfony\Component\Routing\Annotation\Route('/api/lien', name: 'api_lien', methods: ['GET'])]
    #[OA\Get(
        path: '/api/lien',
        description: 'Retourne tous les liens',
        summary: 'Liste des liens',
        tags: ['Lien'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des liens',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(type: Lien::class)
                    )
                )
            ),
        ]
    )]
    public function index(LienRepository $lienRepository, SerializerInterface $serializer): JsonResponse
    {
        $liens = $lienRepository->findAll();
        $jsonLiensList = $serializer->serialize($liens, 'json');

        return new JsonResponse($jsonLiensList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/lien/{id}', name: 'api_lien_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/lien/{id}',
        description: 'Retourne les détails du lien par son ID',
        summary: 'Détails du lien',
        tags: ['Lien'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID du lien',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails du lien',
                content: new OA\JsonContent(
                    ref: new Model(type: Lien::class)
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Lien introuvable'
            ),
        ]
    )]
    public function show(int $id, LienRepository $lienRepository, SerializerInterface $serializer): JsonResponse
    {
        // Trouver un Lien par son ID
        $lien = $lienRepository->find($id);

        if (!$lien) {
            return new JsonResponse(['message' => 'Lien introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Sérialiser les données
        $jsonLien = $serializer->serialize($lien, 'json');

        // Retourner la réponse
        return new JsonResponse($jsonLien, Response::HTTP_OK, [], true);
    }
    #[Route('/api/lien', name: 'api_lien_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/lien',
        description: 'Crée d\'un lien',
        summary: "Création d 'un lien",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: Lien::class)
            )
        ),
        tags: ['Lien'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Lien créée avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        // Désérialiser les données JSON dans l'entité Lien
        $lien = $serializer->deserialize($data, Lien::class, 'json');

        $em->persist($lien);
        $em->flush();

        return new JsonResponse(['message' => 'Lien créée avec succès'], Response::HTTP_CREATED);
    }
}
