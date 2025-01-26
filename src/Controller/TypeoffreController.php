<?php

namespace App\Controller;

use App\Repository\TypeoffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class TypeoffreController extends AbstractController
{
    #[Route('/api/typeoffre', name: 'app_typeoffre')]
    public function index(TypeoffreRepository $typeoffreRepository, SerializerInterface $serializer): JsonResponse
    {
        $typeoffres = $typeoffreRepository->findAll();
        $jsonTypeoffresList = $serializer->serialize($typeoffres, 'json');

        return new JsonResponse($jsonTypeoffresList, Response::HTTP_OK, [], true);
    }
}
