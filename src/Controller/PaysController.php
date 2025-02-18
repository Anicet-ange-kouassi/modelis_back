<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaysController extends AbstractController
{
    #[OA\Get(
        path: '/api/pays',
        description: 'Retourne tous les pays',
        summary: 'Liste des pays',
        tags: ['Pays'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des pays',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Pays::class))
                )
            ),
        ]
    )]
    #[Route('/api/pays', name: 'api_pays_list', methods: ['GET'])]
    public function index(PaysRepository $paysRepository): JsonResponse
    {
        $pays = $paysRepository->findAll();

        return $this->json($pays);
    }

    #[OA\Post(
        path: '/api/pays',
        description: 'Crée un nouveau pays',
        summary: "Création d'un pays",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Pays::class))
        ),
        tags: ['Pays'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Pays créé avec succès'
            ),
        ]
    )]
    #[Route('/api/pays', name: 'api_pays_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pays = new Pays();
        $pays->setCode($data['code']);
        $pays->setNom($data['nom']);

        $em->persist($pays);
        $em->flush();

        return $this->json(['message' => 'Pays créé avec succès'], 201);
    }
}
