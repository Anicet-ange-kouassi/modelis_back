<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PersonneController extends AbstractController
{
    #[Route('/api/personne', methods: ['GET'])]
    public function index(PersonneRepository $personneRepository): JsonResponse
    {
        $personnes = $personneRepository->findAll();

        return $this->json($personnes);
    }

    #[Route('/personne', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $personne = new Personne();
        $personne->setNom($data['nom'] ?? null);
        $personne->setPrenom($data['prenom'] ?? null);
        $personne->setEmail($data['email'] ?? null);
        $personne->setDateNaissance(new \DateTime($data['dateNaissance'] ?? 'now'));

        $entityManager->persist($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personne created'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/personne/{id}', methods: ['GET'])]
    public function show(PersonneRepository $personneRepository, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($personne);
    }

    #[Route('/personne/{id}', methods: ['PUT'])]
    public function update(Request $request, PersonneRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $personne->setNom($data['nom'] ?? $personne->getNom());
        $personne->setPrenom($data['prenom'] ?? $personne->getPrenom());
        $personne->setEmail($data['email'] ?? $personne->getEmail());
        $personne->setDateNaissance(new \DateTime($data['dateNaissance'] ?? $personne->getDateNaissance()->format('Y-m-d')));

        $entityManager->flush();

        return $this->json(['status' => 'Personne updated']);
    }

    #[Route('/personne/{id}', methods: ['DELETE'])]
    public function delete(PersonneRepository $personneRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $personne = $personneRepository->find($id);

        if (!$personne) {
            return $this->json(['error' => 'Personne not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($personne);
        $entityManager->flush();

        return $this->json(['status' => 'Personne deleted']);
    }
}
