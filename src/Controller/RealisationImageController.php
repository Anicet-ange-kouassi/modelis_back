<?php

namespace App\Controller;

use App\Entity\RealisationImage;
use App\Repository\RealisationImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class RealisationImageController extends AbstractController
{

    #[Route('/api/realisation-image', name: 'api_realisation_image_list', methods: ['GET'])]
    public function index(RealisationImageRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $images = $repository->findAll();

        $json = $serializer->serialize(
            $images,
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['realisationId']]
        );

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }


    #[Route('/api/realisation-image/{id}', name: 'api_realisation_image_detail', methods: ['GET'])]
    public function show(int $id, RealisationImageRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $image = $repository->find($id);

        if (!$image) {
            return new JsonResponse(['message' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonImage = $serializer->serialize(
            $image,
            'json',
            [AbstractNormalizer::IGNORED_ATTRIBUTES => ['realisationId']]
        );

        return new JsonResponse($jsonImage, Response::HTTP_OK, [], true);
    }

    #[Route('/api/realisation-image', name: 'api_realisation_image_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $image = $serializer->deserialize($data, RealisationImage::class, 'json');
        $em->persist($image);
        $em->flush();

        return new JsonResponse(['message' => 'Image ajoutée avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/realisation-image/{id}', name: 'api_realisation_image_update', methods: ['PUT'])]
    public function update(int $id, Request $request, RealisationImageRepository $repository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $image = $repository->find($id);

        if (!$image) {
            return new JsonResponse(['message' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        $serializer->deserialize($data, RealisationImage::class, 'json', ['object_to_populate' => $image]);

        $em->flush();

        return new JsonResponse(['message' => 'Image mise à jour avec succès'], Response::HTTP_OK);
    }
}
