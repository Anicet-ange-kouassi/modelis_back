<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlogController extends AbstractController
{
    #[Route('/api/blog', name: 'api_blog_list', methods: ['GET'])]
    public function index(BlogRepository $blogRepository, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $blogs = $blogRepository->findAll();

        // Enregistrer une action "Lecture"
        $this->logAction($em, 'Lecture', 'blog', null);

        $jsonBlogs = $serializer->serialize($blogs, 'json');

        return new JsonResponse($jsonBlogs, Response::HTTP_OK, [], true);
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
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $data = $request->getContent();

        $blog = $serializer->deserialize($data, Blog::class, 'json');
        $blog->setUtilisateurid($this->getUser());

        $em->persist($blog);
        $em->flush();

        // Enregistrer une action "Ajout"
        $this->logAction($em, 'Ajout', 'blog', $blog->getId());

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
