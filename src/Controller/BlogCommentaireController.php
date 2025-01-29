<?php

namespace App\Controller;

use App\Entity\BlogCommentaire;
use App\Repository\BlogCommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class BlogCommentaireController extends AbstractController
{
    #[Route('/api/blog-commentaire', name: 'api_blog_comment_list', methods: ['GET'])]
    public function index(int $blogId, BlogCommentaireRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $comments = $repository->findByBlogId($blogId); // Récupère les commentaires associés au blogId
        $jsonComments = $serializer->serialize($comments, 'json'); // Sérialise les commentaires en JSON

        return new JsonResponse($jsonComments, Response::HTTP_OK, [], true); // Retourne une réponse JSON
    }


    #[Route('/api/blog/{blogId}/commentaires', name: 'api_blog_comment_create', methods: ['POST'])]
    public function create(int $blogId, Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent(); // Récupère les données brutes de la requête POST

        $comment = $serializer->deserialize($data, BlogCommentaire::class, 'json'); // Transforme les données JSON en objet BlogCommentaire
        $comment->setBlogId($blogId); // Associe le commentaire au blog spécifié

        $em->persist($comment); // Prépare l'insertion en base de données
        $em->flush(); // Exécute l'insertion

        return new JsonResponse(['message' => 'Commentaire créé avec succès'], Response::HTTP_CREATED); // Réponse de confirmation
    }


    #[Route('/api/commentaires/{id}', name: 'api_blog_comment_update', methods: ['PUT'])]
    public function update(int $id, Request $request, BlogCommentaireRepository $repository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $comment = $repository->find($id); // Recherche le commentaire par son ID

        if (!$comment) {
            return new JsonResponse(['message' => 'Commentaire introuvable'], Response::HTTP_NOT_FOUND); // Si non trouvé
        }

        $data = $request->getContent(); // Récupère les données JSON de la requête
        $serializer->deserialize($data, BlogCommentaire::class, 'json', ['object_to_populate' => $comment]); // Met à jour l'objet existant

        $em->flush(); // Sauvegarde les modifications

        return new JsonResponse(['message' => 'Commentaire mis à jour avec succès'], Response::HTTP_OK); // Réponse de confirmation
    }

    #[Route('/api/commentaires/{id}', name: 'api_blog_comment_delete', methods: ['DELETE'])]
    public function delete(int $id, BlogCommentaireRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $comment = $repository->find($id); // Recherche le commentaire par son ID

        if (!$comment) {
            return new JsonResponse(['message' => 'Commentaire introuvable'], Response::HTTP_NOT_FOUND); // Si non trouvé
        }

        $em->remove($comment); // Marque le commentaire pour suppression
        $em->flush(); // Exécute la suppression

        return new JsonResponse(['message' => 'Commentaire supprimé avec succès'], Response::HTTP_OK); // Réponse de confirmation
    }

}
