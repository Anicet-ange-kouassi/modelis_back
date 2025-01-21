<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaysController extends AbstractController
{
    #[Route('/api/pays', name: 'api_pays_list', methods: ['GET'])]
    /**
     * @OA\Get(
     *     path="/api/pays",
     *     summary="Liste les pays",
     *     tags={"Pays"}
     * )
     */
    public function index(PaysRepository $paysRepository): JsonResponse
    {
        $pays = $paysRepository->findAll();

        return $this->json($pays);
    }

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
