<?php

namespace App\Controller;

use App\Entity\Typelien;
use App\Repository\TypelienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class TypelienController extends AbstractController
{
    #[OA\Get(
        path: '/api/typelien',
        description: 'Retourne tous les types de liens',
        summary: 'Liste des types de lien',
        tags: ['Typelien'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des types de lien',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Typelien::class))
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Aucun type de lien trouvé'
            ),
        ]
    )]
    #[\Symfony\Component\Routing\Annotation\Route('/api/typelien', name: 'app_typelien', methods: ['GET'])]
    public function index(TypelienRepository $typelienRepository, SerializerInterface $serializer): Response
    {
        $Typelien = $typelienRepository->findAll();
        $typeLienJson = $serializer->serialize($Typelien, 'json');

        return new JsonResponse($typeLienJson, Response::HTTP_OK, [], true);
    }

    #[OA\Post(
        path: '/api/typelien',
        description: 'Crée un nouveau type de lien',
        summary: "Création d'un type de lien",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Typelien::class))
        ),
        tags: ['Typelien'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Type de lien créé avec succès'
            ),
        ]
    )]
    #[Route('/api/typelien', name: 'api_lien_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        // Désérialiser les données JSON dans l'entité Type de lien
        $lien = $serializer->deserialize($data, Typelien::class, 'json');

        $em->persist($lien);
        $em->flush();

        return new JsonResponse(['message' => 'Type de Lien créée avec succès'], Response::HTTP_CREATED);
    }
}
