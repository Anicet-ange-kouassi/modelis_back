<?php

namespace App\Controller;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RealisationController extends AbstractController
{
    #[Route('/api/realisation', name: 'api_realisation_list', methods: ['GET'])]
    public function index(Request $request, RealisationRepository $realisationRepository, SerializerInterface $serializer): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10); // Par défaut, 10 éléments
        $exclude = $request->query->getInt('exclude', 0); // Par défaut, aucun ID à exclure (0)

        $queryBuilder = $realisationRepository->createQueryBuilder('r');

        if ($exclude > 0) {
            $queryBuilder->andWhere('r.id != :exclude')
                ->setParameter('exclude', $exclude);
        }

        $queryBuilder->setMaxResults($limit);

        $realisations = $queryBuilder->getQuery()->getResult();
        $jsonRealisations = $serializer->serialize($realisations, 'json');

        return new JsonResponse($jsonRealisations, Response::HTTP_OK, [], true);
    }

    /**
     * Détails d'une réalisation spécifique par son ID.
     */
    #[Route('/api/realisation/{id}', name: 'api_realisation_detail', methods: ['GET'])]
    public function show(int $id, RealisationRepository $realisationRepository, SerializerInterface $serializer): JsonResponse
    {
        $realisation = $realisationRepository->find($id);

        if (!$realisation) {
            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
        }

        $jsonRealisation = $serializer->serialize($realisation, 'json');

        return new JsonResponse($jsonRealisation, Response::HTTP_OK, [], true);
    }
}

//
// namespace App\Controller;
//
// use App\Entity\Realisation;
// use App\Repository\RealisationRepository;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Serializer\SerializerInterface;
//
// class RealisationController extends AbstractController
// {
//    #[Route('/api/realisation', name: 'api_realisation_list', methods: ['GET'])]
//    public function index(RealisationRepository $realisationRepository, SerializerInterface $serializer): JsonResponse
//    {
//        $realisations = $realisationRepository->findAll();
//        $jsonRealisations = $serializer->serialize($realisations, 'json');
//
//        return new JsonResponse($jsonRealisations, Response::HTTP_OK, [], true);
//    }
//
//    #[Route('/api/realisation/{id}', name: 'api_realisation_detail', methods: ['GET'])]
//    public function show(int $id, RealisationRepository $realisationRepository, SerializerInterface $serializer): JsonResponse
//    {
//        $realisation = $realisationRepository->find($id);
//
//        if (!$realisation) {
//            return new JsonResponse(['message' => 'Réalisation introuvable'], Response::HTTP_NOT_FOUND);
//        }
//
//        $jsonRealisation = $serializer->serialize($realisation, 'json');
//
//        return new JsonResponse($jsonRealisation, Response::HTTP_OK, [], true);
//    }
//
//    #[Route('/api/realisation', name: 'api_realisation_create', methods: ['POST'])]
//    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
//    {
//        $data = $request->getContent();
//
//        $realisation = $serializer->deserialize($data, Realisation::class, 'json');
//
//        $em->persist($realisation);
//        $em->flush();
//
//        return new JsonResponse(['message' => 'Réalisation créée avec succès'], Response::HTTP_CREATED);
//    }
// }
