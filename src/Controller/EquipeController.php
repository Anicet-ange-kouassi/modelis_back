<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EquipeController extends AbstractController
{
    #[Route('/api/equipe', name: 'api_equipe', methods: ['GET'])]
    public function index(EquipeRepository $equipeRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupérer toutes les équipes
        $equipes = $equipeRepository->findAll();

        // Sérialiser les équipes en JSON
        $jsonEquipList = $serializer->serialize($equipes, 'json');

        // Retourner la réponse JSON
        return new JsonResponse($jsonEquipList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/equipe/{id}', name: 'api_equipe_detail', methods: ['GET'])]
    public function show(int $id, EquipeRepository $equipeRepository, SerializerInterface $serializer): JsonResponse
    {
        // Trouver une équipe par son ID
        $equipe = $equipeRepository->find($id);

        if (!$equipe) {
            return new JsonResponse(['message' => 'Équipe introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Sérialiser les données
        $jsonEquipe = $serializer->serialize($equipe, 'json');

        // Retourner la réponse
        return new JsonResponse($jsonEquipe, Response::HTTP_OK, [], true);
    }

    #[Route('/api/equipe', name: 'api_equipe_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        // Désérialiser les données JSON dans l'entité Equipe
        $equipe = $serializer->deserialize($data, Equipe::class, 'json');

        $em->persist($equipe);
        $em->flush();

        return new JsonResponse(['message' => 'Équipe créée avec succès'], Response::HTTP_CREATED);
    }

}
