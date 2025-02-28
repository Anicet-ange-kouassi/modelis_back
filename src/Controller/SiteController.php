<?php

namespace App\Controller;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[OA\Get(
        path: '/api/site',
        description: 'Retourne tous les sites',
        summary: 'Liste des sites',
        tags: ['Site'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des sites',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Site::class))
                )
            ),
        ]
    )]
    #[Route('/api/site', name: 'api_site_list', methods: ['GET'])]
    public function index(SiteRepository $siteRepository): JsonResponse
    {
        $sites = $siteRepository->findAll();

        return $this->json($sites, 200, [], ['groups' => 'site:read']);
    }

    #[OA\Post(
        path: '/api/site',
        description: 'Crée un nouveau site',
        summary: "Création d'un site",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Site::class))
        ),
        tags: ['Site'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Site créé avec succès'
            ),
        ]
    )]
    #[Route('/api/site', name: 'api_site_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $site = new Site();
        $site->setCode($data['code']);
        $site->setNom($data['nom']);

        $em->persist($site);
        $em->flush();

        return $this->json(['message' => 'Site créé avec succès'], 201);
    }

    #[OA\Get(
        path: '/api/site/{id}',
        description: 'Retourne un site par son identifiant',
        summary: "Détails d'un site",
        tags: ['Site'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Détails d'un site",
                content: new OA\JsonContent(ref: new Model(type: Site::class))
            ),
            new OA\Response(
                response: 404,
                description: 'Site non trouvé'
            ),
        ]
    )]
    #[Route('/api/site/{id}', name: 'api_site_show', methods: ['GET'])]
    public function show(int $id, SiteRepository $siteRepository): JsonResponse
    {
        $site = $siteRepository->find($id);
        if (!$site) {
            return $this->json(['message' => 'Site non trouvé'], 404);
        }

        return $this->json($site, 200, [], ['groups' => 'site:read']);
    }

    #[OA\Put(
        path: '/api/site/{id}',
        description: 'Met à jour un site existant',
        summary: "Mise à jour d'un site",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: Site::class))
        ),
        tags: ['Site'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Site mis à jour avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Site non trouvé'
            ),
        ]
    )]
    #[Route('/api/site/{id}', name: 'api_site_update', methods: ['PUT'])]
    public function update(int $id, Request $request, SiteRepository $siteRepository, EntityManagerInterface $em): JsonResponse
    {
        $site = $siteRepository->find($id);
        if (!$site) {
            return $this->json(['message' => 'Site non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['code'])) {
            $site->setCode($data['code']);
        }
        if (isset($data['nom'])) {
            $site->setNom($data['nom']);
        }

        $em->flush();

        return $this->json(['message' => 'Site mis à jour avec succès'], 200);
    }

    #[OA\Delete(
        path: '/api/site/{id}',
        description: 'Supprime un site par son identifiant',
        summary: "Suppression d'un site",
        tags: ['Site'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Site supprimé avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Site non trouvé'
            ),
        ]
    )]
    #[Route('/api/site/{id}', name: 'api_site_delete', methods: ['DELETE'])]
    public function delete(int $id, SiteRepository $siteRepository, EntityManagerInterface $em): JsonResponse
    {
        $site = $siteRepository->find($id);
        if (!$site) {
            return $this->json(['message' => 'Site non trouvé'], 404);
        }

        $em->remove($site);
        $em->flush();

        return $this->json(['message' => 'Site supprimé avec succès'], 200);
    }
}
