<?php

namespace App\Controller;

use App\Entity\Typelien;
use App\Repository\TypelienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class TypelienController extends AbstractController
{
    #[\Symfony\Component\Routing\Annotation\Route('/api/typelien', name: 'app_typelien', methods: ['GET'])]
    public function index(TypelienRepository $typelienRepository, SerializerInterface $serializer): Response
    {
        $Typelien = $typelienRepository->findAll();
        $typeLienJson = $serializer->serialize($Typelien, 'json');

        return new Response($typeLienJson, Response::HTTP_OK);
    }

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
