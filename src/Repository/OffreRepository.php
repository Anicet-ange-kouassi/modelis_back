<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    /**
     * Retourne toutes les offres dont le pays a le code spécifié.
     *
     * @param string $countryCode Le code du pays (par exemple "FRA", "MLI", "SEN")
     *
     * @return Offre[] Retourne un tableau d'objets Offre
     */
    public function findByCountryCode(string $countryCode): array
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.paysId', 'p')
            ->addSelect('p')
            ->where('p.code = :code')
            ->setParameter('code', $countryCode);

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne toutes les offres avec leurs relations (par exemple, pays, personnes et leurs profils).
     *
     * @return Offre[] Retourne un tableau d'objets Offre
     */
    public function findAllWithRelations(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.paysId', 'p')
            ->addSelect('p')
            ->leftJoin('e.typeOffreId', 'type')
            ->addSelect('type');

        return $qb->getQuery()->getResult();
    }
}
