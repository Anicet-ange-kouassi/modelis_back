<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Pays;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactController extends AbstractController
{
    #[Route('/api/contact', name: 'api_contact_list', methods: ['GET'])]
    public function index(ContactRepository $contactRepository, SerializerInterface $serializer): JsonResponse
    {
        $contacts = $contactRepository->findAll();
        $jsonContactList = $serializer->serialize($contacts, 'json');

        return new JsonResponse($jsonContactList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/contact', name: 'api_contact_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pays = $em->getRepository(Pays::class)->find($data['paysId']);
        if (!$pays) {
            return new JsonResponse(['message' => 'Pays non trouvé'], 404);
        }

        $contact = new Contact();
        $contact->setEmail($data['email']);
        $contact->setTel($data['tel']);
        $contact->setAdresse($data['adresse']);
        $contact->setDateCreation(new \DateTime());
        $contact->setPays($pays);

        $em->persist($contact);
        $em->flush();

        return $this->json(['message' => 'Contact créé avec succès'], 201);
    }

    #[Route('/api/contact/{id}', name: 'api_contact_get', methods: ['GET'])]
    public function getById(int $id, ContactRepository $contactRepository, SerializerInterface $serializer): JsonResponse
    {
        $contact = $contactRepository->find($id);
        if (!$contact) {
            return new JsonResponse(['message' => 'Contact not found'], 404);
        }
        $jsonContact = $serializer->serialize($contact, 'json');

        return new JsonResponse($jsonContact, Response::HTTP_OK, []);
    }

    #[Route('/api/contact/{id}', name: 'api_contact_update', methods: ['PUT'])]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Contact $contact = null,
    ): JsonResponse {
        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $contact->setEmail($data['email']);
        }
        if (isset($data['tel'])) {
            $contact->setTel($data['tel']);
        }
        if (isset($data['adresse'])) {
            $contact->setAdresse($data['adresse']);
        }
        if (isset($data['dateModification'])) {
            $contact->setDateModification(new \DateTime($data['dateModification']));
        } else {
            $contact->setDateModification(new \DateTime());
        }

        $em->persist($contact);
        $em->flush();

        return $this->json(['message' => 'Contact modifié avec succès'], Response::HTTP_OK);
    }

    #[Route('/api/contact/{id}', name: 'api_contact_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, ?Contact $contact = null): JsonResponse
    {
        if (!$contact) {
            return $this->json(['message' => 'Contact non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($contact);
        $em->flush();

        return $this->json(['message' => 'Contact supprimé avec succès'], Response::HTTP_OK);
    }
}
