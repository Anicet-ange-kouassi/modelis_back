<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\BlogCommentaire;
use App\Repository\BlogCommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BlogCommentaireController extends AbstractController
{
    #[OA\Get(
        path: '/api/blog-commentaire',
        description: 'Retourne tous les blog-commentaires',
        summary: 'Liste des blog-commentaires',
        tags: ['BlogCommentaire'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des blog-commentaires',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: BlogCommentaire::class))
                )
            ),
        ]
    )]
    #[Route('/api/blog-commentaire', name: 'api_blog_comment_list', methods: ['GET'])]
    public function index(int $blogId, BlogCommentaireRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $comments = $repository->findByBlogId($blogId); // Récupère les commentaires associés au blogId
        $jsonComments = $serializer->serialize($comments, 'json'); // Sérialise les commentaires en JSON

        return new JsonResponse($jsonComments, Response::HTTP_OK, [], true); // Retourne une réponse JSON
    }

    #[OA\Post(
        path: '/api/blog/{blogId}/commentaires',
        description: 'Crée d\'un commentaire',
        summary: "Création d'un commentaire",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: new Model(type: BlogCommentaire::class))
        ),
        tags: ['BlogCommentaire'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Commentaire cré avec succès'
            ),
        ]
    )]
    #[Route('/api/blog/{blogId}/commentaires', name: 'api_blog_comment_create', methods: ['POST'])]
    public function create(int $blogId, Request $request, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['nom'], $data['commentaire'], $data['email'])) {
            return new JsonResponse(['error' => 'bad request'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifier l'existence du blog
        $blog = $em->getRepository(Blog::class)->find($blogId);
        if (!$blog) {
            return new JsonResponse(['error' => 'Blog non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $message = new BlogCommentaire();
        $message->setCommentaire($data['commentaire']);
        $message->setEmail($data['email']);
        $message->setNom($data['nom']);
        $message->setDateCreation(new \DateTime());
        $message->setBlog($blog); // Utiliser l'entité et non un ID directement

        // Validation des données
        $errors = $validator->validate($message);
        if (count($errors) > 0) {
            return new JsonResponse(['message' => 'Données invalides', 'errors' => (string) $errors], 400);
        }

        // Sauvegarde
        $em->persist($message);
        $em->flush();

        return new JsonResponse(['message' => 'Commentaire créé avec succès'], Response::HTTP_CREATED);
    }
}
