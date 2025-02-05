<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UtilisateurController extends AbstractController
{
    #[Route('api/utilisateur', name: 'app_utilisateur')]
    public function index(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer): Response
    {
        $data = $utilisateurRepository->findAll();
        $jsonUtilisateurList = $serializer->serialize($data, 'json');

        return new JsonResponse($jsonUtilisateurList, Response::HTTP_OK, [], true);
    }
}
