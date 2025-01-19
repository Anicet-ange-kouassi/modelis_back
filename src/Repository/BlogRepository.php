<?php

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    // Exemple d'une méthode personnalisée pour récupérer les blogs par utilisateur
    public function findByUtilisateurId(int $utilisateurId): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.utilisateurId = :utilisateurId')
            ->setParameter('utilisateurId', $utilisateurId)
            ->getQuery()
            ->getResult();
    }
}
