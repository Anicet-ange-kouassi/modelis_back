<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UtilisateurController extends AbstractController
{
    #[OA\Get(
        path: '/api/utilisateur',
        description: 'Retourne tous les utilisateur',
        summary: 'Liste des utilisateur',
        tags: ['Utilisateur'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des utilisateur',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Utilisateur::class))
                )
            ),
        ]
    )]
    #[Route('api/utilisateur', name: 'app_utilisateur')]
    public function index(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $data = $utilisateurRepository->findAll();
        $jsonUtilisateurList = $serializer->serialize($data, 'json');

        return new JsonResponse($jsonUtilisateurList, Response::HTTP_OK, [], true);
    }

    #[\Symfony\Component\Routing\Annotation\Route('/api/utilisateur', name: 'api_utilisateur_create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/utilisateur',
        description: 'Crée un nouveau utilisateur',
        summary: "Création d'un utilisateur",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Utilisateur::class))
        ),
        tags: ['Utilisateur'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Utilisateur créé avec succès'
            ),
        ]
    )]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $user = $serializer->deserialize($data, Utilisateur::class, 'json');

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], Response::HTTP_CREATED);
    }
}
