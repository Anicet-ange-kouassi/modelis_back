<?php

namespace App\Controller;

use App\Entity\Lien;
use App\Repository\LienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class LienController extends AbstractController
{
    #[\Symfony\Component\Routing\Annotation\Route('/api/lien', name: 'api_lien', methods: ['GET'])]
    public function index(LienRepository $lienRepository, SerializerInterface $serializer): JsonResponse
    {
        $liens = $lienRepository->findAll();
        $jsonLiensList = $serializer->serialize($liens, 'json');

        return new JsonResponse($jsonLiensList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/lien/{id}', name: 'api_lien_detail', methods: ['GET'])]
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
