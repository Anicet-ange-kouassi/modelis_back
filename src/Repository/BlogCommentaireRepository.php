<?php

namespace App\Repository;

use App\Entity\BlogCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogCommentaire::class);
    }

    /**
     * Récupérer les commentaires par ID de blog.
     */
    public function findByBlogId(int $blogId): array
    {
        return $this->createQueryBuilder('bc')
            ->andWhere('bc.blogId = :blogId')
            ->setParameter('blogId', $blogId)
            ->orderBy('bc.dateCreation', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
