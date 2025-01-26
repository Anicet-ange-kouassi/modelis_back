<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class OffreController extends AbstractController
{
    #[Route('/api/offre', name: 'app_offre')]
    public function index(OffreRepository $offreRepository, SerializerInterface $serializer): JsonResponse
    {
        $offre = $offreRepository->findAll();
        $jsonOffreList = $serializer->serialize($offre, 'json');

        return new JsonResponse($jsonOffreList, Response::HTTP_OK, [], true);
    }
}
