<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BlogController extends AbstractController
{
    #[OA\Get(
        description: 'Retourne tous les blogs enregistrés.',
        summary: 'Récupère la liste des blogs',
        tags: ['Blog'], responses: [
            new OA\Response(
                response: 200,
                description: 'Liste des blogs',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: 'src/Entity/Blog.php'))
            ),
        ]
    )]
    #[Route('/api/blog', name: 'get_blogs', methods: ['GET'])]
    public function getAllBlogs(BlogRepository $blogRepository): JsonResponse
    {
        $blogs = $blogRepository->findAllWithRelations();

        $response = array_map(fn ($blog) => [
            'id' => $blog->getId(),
            'libelle' => $blog->getLibelle(),
            'image' => $blog->getImage(),
            'description' => $blog->getDescription(),
            'dateCreation' => $blog->getDateCreation()->format('Y-m-d H:i:s'),
            'utilisateur' => $blog->getUtilisateurId() ? [
                'nom' => $blog->getUtilisateurId()->getPersonneId()->getNom(),
                'prenom' => $blog->getUtilisateurId()->getPersonneId()->getPrenom(),
                'image' => $blog->getUtilisateurId()->getPersonneId()->getImage(),
            ] : null,
        ], $blogs);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    #[Route('/user/{utilisateurId}', name: 'get_blogs_by_user', methods: ['GET'])]
    #[OA\Get(
        description: 'Retourne tous les blogs appartenant à un utilisateur spécifique.',
        summary: "Récupère les blogs d'un utilisateur",
        parameters: [
            new OA\Parameter(name: 'utilisateurId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste des blogs de l'utilisateur",
            ),
        ]
    )]
    public function getBlogsByUser(int $utilisateurId, BlogRepository $blogRepository): JsonResponse
    {
        $blogs = $blogRepository->findBAllWithRelations($utilisateurId);

        $response = array_map(fn ($blog) => [
            'id' => $blog->getId(),
            'libelle' => $blog->getLibelle(),
            'image' => $blog->getImage(),
            'description' => $blog->getDescription(),
            'dateCreation' => $blog->getDateCreation()->format('Y-m-d H:i:s'),
            'utilisateur' => $blog->getUtilisateurId() ? [
                'nom' => $blog->getUtilisateurId()->getPersonneId()->getNom(),
                'prenom' => $blog->getUtilisateurId()->getPersonneId()->getPrenom(),
                'image' => $blog->getUtilisateurId()->getPersonneId()->getImage(),
            ] : null,
        ], $blogs);

        return new JsonResponse($response, Response::HTTP_OK);
    }

    #[Route('/api/blog/{id}', name: 'api_blog_detail', methods: ['GET'])]
    public function show(int $id, BlogRepository $blogRepository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $blog = $blogRepository->find($id);

        if (!$blog) {
            return new JsonResponse(['message' => 'Blog introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Enregistrer une action "Lecture"
        $this->logAction($em, 'Lecture', 'blog', $id);

        $jsonBlog = $serializer->serialize($blog, 'json');

        return new JsonResponse($jsonBlog, Response::HTTP_OK, [], true);
    }

    #[Route('/api/blog', name: 'api_blog_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $blog = $serializer->deserialize($data, Blog::class, 'json');
        $blog->setUtilisateurid($this->getUser());

        $em->persist($blog);
        $em->flush();

        return new JsonResponse(['message' => 'Blog créé avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/blog/{id}', name: 'api_blog_update', methods: ['PUT'])]
    public function update(int $id, Request $request, BlogRepository $blogRepository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $blog = $blogRepository->find($id);

        if (!$blog) {
            return new JsonResponse(['message' => 'Blog introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();
        $serializer->deserialize($data, Blog::class, 'json', ['object_to_populate' => $blog]);

        $em->flush();

        // Enregistrer une action "Modification"
        $this->logAction($em, 'Modification', 'blog', $id);

        return new JsonResponse(['message' => 'Blog mis à jour avec succès'], Response::HTTP_OK);
    }

    #[Route('/api/blog/{id}', name: 'api_blog_delete', methods: ['DELETE'])]
    public function delete(int $id, BlogRepository $blogRepository, EntityManagerInterface $em): JsonResponse
    {
        $blog = $blogRepository->find($id);

        if (!$blog) {
            return new JsonResponse(['message' => 'Blog introuvable'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($blog);
        $em->flush();

        // Enregistrer une action "Suppression"
        $this->logAction($em, 'Suppression', 'blog', $id);

        return new JsonResponse(['message' => 'Blog supprimé avec succès'], Response::HTTP_OK);
    }

    private function logAction(EntityManagerInterface $em, string $actionType, string $tableName, ?int $idTable): void
    {
        $action = new Action();
        $action->setAction($actionType);
        $action->setUtilisateurid($this->getUser());
        $action->setNomtable($tableName);
        $action->setIdtable($idTable);

        $em->persist($action);
        $em->flush();
    }
}
