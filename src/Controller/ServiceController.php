<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ServiceController extends AbstractController
{
    #[Route('/api/service', name: 'api_service_list', methods: ['GET'])]
    /**
     * @OA\Get(
     *     path="/api/contact",
     *     @OA\Response(
     *         response="200",
     *     description="Nos contact",
     *     @OA\JsonContent( type="string",description="nos differents contact",
     *     @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))),
     *     )
     * )
     */
    public function index(ServiceRepository $serviceRepository, SerializerInterface $serializer): JsonResponse
    {
        $service = $serviceRepository->findAll();
        $jsonServiceList = $serializer->serialize($service, 'json');

        return new JsonResponse($jsonServiceList, Response::HTTP_OK, [], true);
    }

    #[\Symfony\Component\Routing\Annotation\Route('api/service/{id}', name: 'api_service_detail', methods: ['GET'])]
    public function getServiceById(int $id, ServiceRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $service = $repository->find($id);

        if (!$service) {
            return new JsonResponse(['message' => 'Service introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonData = $serializer->serialize(
            $service,
            'json'
        );

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
