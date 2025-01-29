<?php

namespace App\Controller;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RealisationController extends AbstractController
{
    #[Route('/api/realisation', name: 'api_realisation_list', methods: ['GET'])]
    public function index(RealisationRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $realisations = $repository->findAllWithRelations();

        if (empty($realisations)) {
            return new JsonResponse(['error' => 'No data found'], Response::HTTP_NOT_FOUND);
        }

        $jsonData = $serializer->serialize($realisations, 'json', ['groups' => 'realisation:read']);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }


    #[Route('/api/realisation/{id}', name: 'api_realisation_detail', methods: ['GET'])]
    public function getRealisationWithImages(int $id, RealisationRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $realisation = $repository->find($id);

        if (!$realisation) {
            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonData = $serializer->serialize(
            $realisation,
            'json',
            ['groups' => 'realisation:read'] // Spécifie le groupe à utiliser
        );

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
