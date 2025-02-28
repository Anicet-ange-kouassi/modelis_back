<?php

namespace App\Controller;

use App\Entity\RealisationImage;
use App\Repository\RealisationImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class RealisationImageController extends AbstractController
{
    #[OA\Get(
        path: '/api/realisation-image',
        description: 'Retourne toutes les images des différente réalisations ',
        summary: 'Liste des images de la réalisation',
        tags: ['Realisation_Image'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des images de la réalisation',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: RealisationImage::class))
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Aucune images  de réalisation trouvée'
            ),
        ]
    )]
    #[Route('/api/realisation-image', name: 'api_realisation_image_list', methods: ['GET'])]
    public function index(RealisationImageRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $images = $repository->findAll();

        $json = $serializer->serialize(
            $images,
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['realisationId']]
        );

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[OA\Get(
        path: '/api/realisation-image/{id}',
        description: "Retourne les détails d'une image de la réalisation par son ID",
        summary: "Détails d'une image de la réalisation",
        tags: ['Realisation_Image'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID d\'une image de la réalisation',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Détails d\'une image de la réalisation',
                content: new OA\JsonContent(ref: new Model(type: RealisationImage::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Image introuvable'
            ),
        ]
    )]
    #[Route('/api/realisation-image/{id}', name: 'api_realisation_image_detail', methods: ['GET'])]
    public function show(int $id, RealisationImageRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $image = $repository->find($id);

        if (!$image) {
            return new JsonResponse(['message' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonImage = $serializer->serialize(
            $image,
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['realisationId']]
        );

        return new JsonResponse($jsonImage, Response::HTTP_OK, [], true);
    }
    #[OA\Post(
        path: '/api/realisation-image',
        description: 'Crée une nouvelle image',
        summary: "Création d'une nouvelle image de la realisation",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: RealisationImage::class))
        ),
        tags: ['Realisation_Image'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Image d\'une realisation créé avec succès'
            ),
        ]
    )]
    #[Route('/api/realisation-image', name: 'api_realisation_image_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $image = $serializer->deserialize($data, RealisationImage::class, 'json');
        $em->persist($image);
        $em->flush();

        return new JsonResponse(['message' => 'Image ajoutée avec succès'], Response::HTTP_CREATED);
    }
    #[OA\Put(
        path: '/api/realisation-image/{id}',
        description: 'Met à jour une image de la réalisation existante',
        summary: "Mise à jour d'une image",
        requestBody: new OA\RequestBody(
            description: 'Données de mise à jour d\'une image',
            required: true,
            content: new OA\JsonContent(ref: new Model(type: RealisationImage::class))
        ),
        tags: ['Realisation_Image'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID de l\'image à mettre à jour',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Image mise à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Image introuvable'
            ),
        ]
    )]
    #[Route('/api/realisation-image/{id}', name: 'api_realisation_image_update', methods: ['PUT'])]
    public function update(int $id, Request $request, RealisationImageRepository $repository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $image = $repository->find($id);

        if (!$image) {
            return new JsonResponse(['message' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        $serializer->deserialize($data, RealisationImage::class, 'json', ['object_to_populate' => $image]);

        $em->flush();

        return new JsonResponse(['message' => 'Image mise à jour avec succès'], Response::HTTP_OK);
    }
}
