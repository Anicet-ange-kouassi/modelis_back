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

    public function findBAllWithRelations(int $utilisateurId): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.utilisateurId', 'u')  // Jointure avec l'entité Utilisateur
            ->addSelect('u')                  // Inclure les données utilisateur
            ->leftJoin('u.personneId', 'p')   // Jointure avec l'entité Personne
            ->addSelect('p')                  // Inclure les données personne
            ->andWhere('b.utilisateurId = :utilisateurId') // Filtrer par utilisateur
            ->setParameter('utilisateurId', $utilisateurId)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.utilisateurId', 'u')
            ->addSelect('u')
            ->leftJoin('u.personneId', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();
    }
}
