<?php

namespace App\Controller;

use App\Repository\InfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class InfoController extends AbstractController
{
    #[Route('/api/info', name: 'app_info')]
    public function index(InfoRepository $infoRepository, SerializerInterface $serializer): JsonResponse
    {
        $infos = $infoRepository->findAll();
        $jsonInfoList = $serializer->serialize($infos, 'json');

        return new JsonResponse($jsonInfoList, Response::HTTP_OK, [], true);
    }
}
