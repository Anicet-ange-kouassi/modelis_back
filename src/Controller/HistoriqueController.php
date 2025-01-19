<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HistoriqueController extends AbstractController
{
    #[Route('/api/historique', name: 'api_historique_list', methods: ['GET'])]
    public function index(HistoriqueRepository $historiqueRepository, SerializerInterface $serializer): JsonResponse
    {
        $historiques = $historiqueRepository->findAll();
        $jsonHistoriques = $serializer->serialize($historiques, 'json');

        return new JsonResponse($jsonHistoriques, Response::HTTP_OK, [], true);
    }

    #[Route('/api/historique/{id}', name: 'api_historique_detail', methods: ['GET'])]
    public function show(int $id, HistoriqueRepository $historiqueRepository, SerializerInterface $serializer): JsonResponse
    {
        $historique = $historiqueRepository->find($id);

        if (!$historique) {
            return new JsonResponse(['message' => 'Historique introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonHistorique = $serializer->serialize($historique, 'json');

        return new JsonResponse($jsonHistorique, Response::HTTP_OK, [], true);
    }

    #[Route('/api/historique', name: 'api_historique_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $historique = $serializer->deserialize($data, Historique::class, 'json');
        $em->persist($historique);
        $em->flush();

        return new JsonResponse(['message' => 'Historique créé avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/historique/{id}', name: 'api_historique_update', methods: ['PUT'])]
    public function update(int $id, Request $request, HistoriqueRepository $historiqueRepository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $historique = $historiqueRepository->find($id);

        if (!$historique) {
            return new JsonResponse(['message' => 'Historique introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        $serializer->deserialize($data, Historique::class, 'json', ['object_to_populate' => $historique]);
        $historique->setDateModification(new \DateTime());

        $em->flush();

        return new JsonResponse(['message' => 'Historique mis à jour avec succès'], Response::HTTP_OK);
    }
}
