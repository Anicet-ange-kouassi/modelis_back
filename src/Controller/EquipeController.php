<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/equipe')]
class EquipeController extends AbstractController
{
    #[Route('', name: 'api_equipe', methods: ['GET'])]
    #[OA\Get(
        path: '/api/equipe',
        description: 'Retourne toutes les équipes',
        summary: 'Liste des équipes',
        tags: ['Equipe'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des équipes',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(type: Equipe::class)
                    )
                )
            ),
        ]
    )]
    public function index(EquipeRepository $equipeRepository, SerializerInterface $serializer): JsonResponse
    {
        $equipes = $equipeRepository->findAll();
        $jsonEquipList = $serializer->serialize($equipes, 'json');

        return new JsonResponse($jsonEquipList, Response::HTTP_OK, [], true);
    }

    #[Route('/{payscode}', name: 'api_equipe_code', methods: ['GET'])]
    #[OA\Get(
        path: '/api/equipe/{payscode}',
        description: 'Retourne les équipes correspondant au code pays spécifié',
        summary: 'Liste des équipes par code pays',
        tags: ['Equipe'],
        parameters: [
            new OA\Parameter(
                name: 'payscode',
                description: 'Code du pays (ex: CI, FR, US...)',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des équipes filtrées par code pays',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(type: Equipe::class)
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Équipe introuvable'
            ),
        ]
    )]
    public function getEquipeByPaysCode(
        Request $request,
        EquipeRepository $equipeRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        $paysCodeParam = $request->get('payscode');

        if ($paysCodeParam) {
            $equipes = $equipeRepository->findByCountryCode($paysCodeParam);
        } else {
            $equipes = $equipeRepository->findAllWithRelations();
        }

        $json = $serializer->serialize($equipes, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    #[Route('/details/{id}', name: 'api_equipe_detail', methods: ['GET'])]
    #[OA\Get(
        path: '/api/equipe/details/{id}',
        description: "Retourne les détails d'une équipe par son ID",
        summary: "Détails d'une équipe",
        tags: ['Equipe'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "ID de l'équipe",
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Détails de l'équipe",
                content: new OA\JsonContent(
                    ref: new Model(type: Equipe::class)
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Équipe introuvable'
            ),
        ]
    )]
    public function show(int $id, EquipeRepository $equipeRepository, SerializerInterface $serializer): JsonResponse
    {
        $equipe = $equipeRepository->find($id);

        if (!$equipe) {
            return new JsonResponse(['message' => 'Équipe introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonEquipe = $serializer->serialize($equipe, 'json');

        return new JsonResponse($jsonEquipe, Response::HTTP_OK, [], true);
    }

    #[Route('', name: 'api_equipe_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/equipe',
        description: 'Crée une nouvelle équipe',
        summary: "Création d'une équipe",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: Equipe::class)
            )
        ),
        tags: ['Equipe'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Équipe créée avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();
        $equipe = $serializer->deserialize($data, Equipe::class, 'json');

        $em->persist($equipe);
        $em->flush();

        return new JsonResponse(['message' => 'Équipe créée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_equipe_delete', methods: ['DELETE'])]
    #[OA\Delete(
        path: '/api/equipe/{id}',
        description: 'Supprime une équipe par son ID.',
        summary: "Suppression d'une équipe",
        tags: ['Equipe'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "ID de l'équipe à supprimer",
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Équipe supprimée avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Équipe introuvable'
            ),
        ]
    )]
    public function deleteEquipe(
        int $id,
        EquipeRepository $equipeRepository,
        EntityManagerInterface $em,
    ): JsonResponse {
        $equipe = $equipeRepository->find($id);

        if (!$equipe) {
            return new JsonResponse(['message' => 'Équipe introuvable'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($equipe);
        $em->flush();

        return new JsonResponse(['message' => 'Équipe supprimée avec succès'], Response::HTTP_OK);
    }
}
