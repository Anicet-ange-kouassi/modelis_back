<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetenceController extends AbstractController
{
    #[Route('/api/competence', name: 'api_competence_list', methods: ['GET'])]
    public function index(CompetenceRepository $competenceRepository, SerializerInterface $serializer): JsonResponse
    {
        $competences = $competenceRepository->findAll();
        $jsonCompetences = $serializer->serialize($competences, 'json');

        return new JsonResponse($jsonCompetences, Response::HTTP_OK, [], true);
    }

    #[Route('/api/competence/{id}', name: 'api_competence_detail', methods: ['GET'])]
    public function show(int $id, CompetenceRepository $competenceRepository, SerializerInterface $serializer): JsonResponse
    {
        $competence = $competenceRepository->find($id);

        if (!$competence) {
            return new JsonResponse(['message' => 'Compétence introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonCompetence = $serializer->serialize($competence, 'json');

        return new JsonResponse($jsonCompetence, Response::HTTP_OK, [], true);
    }

    #[Route('/api/competence', name: 'api_competence_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $competence = $serializer->deserialize($data, Competence::class, 'json');

        $em->persist($competence);
        $em->flush();

        return new JsonResponse(['message' => 'Compétence créée avec succès'], Response::HTTP_CREATED);
    }
}
