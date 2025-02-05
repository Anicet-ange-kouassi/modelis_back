<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class OffreController extends AbstractController
{
    #[Route('/api/offre', name: 'api_offre')]
    public function index(OffreRepository $offreRepository, SerializerInterface $serializer): JsonResponse
    {
        $offre = $offreRepository->findAll();
        $jsonOffreList = $serializer->serialize($offre, 'json');

        return new JsonResponse($jsonOffreList, Response::HTTP_OK, [], true);
    }

    #[\Symfony\Component\Routing\Annotation\Route('/api/offre/{payscode}', name: 'api_offre_code', methods: ['GET'])]
    public function getOffreByPaysCode(
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        $paysCodeParam = $request->get('payscode'); // récupère le code depuis l'URL

        if ($paysCodeParam) {
            $offres = $offreRepository->findByCountryCode($paysCodeParam);
        } else {
            $offres = $offreRepository->findAllWithRelations();
        }

        $json = $serializer->serialize($offres, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
