<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }
    /**
     * Retourne tous les contacts dont le pays a le code spécifié.
     *
     * @param string $countryCode Le code du pays (par exemple "FRA", "MLI", "SEN")
     *
     * @return Contact[] Retourne un tableau d'objets contact
     */
    public function findByCountryCode(string $countryCode): array
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.pays', 'p')
            ->addSelect('p')
            ->where('p.code = :code')
            ->setParameter('code', $countryCode);

        return $qb->getQuery()->getResult();
    }

}
