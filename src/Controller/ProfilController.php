<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ProfilController extends AbstractController
{
    #[Route('/api/profil', name: 'app_profil')]
    public function index(ProfilRepository $profilRepository, SerializerInterface $serializer): JsonResponse
    {
        $profils = $profilRepository->findAll();
        $jsonProfils = $serializer->serialize($profils, 'json');

        return new JsonResponse($jsonProfils, Response::HTTP_OK, [], true);
    }
}
